<?php
$conn = require '../php/db_connect.php';

$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');

$point_to_time_factor = 1;


// Get course units
$stmt = $conn->prepare("SELECT course_units.*, course_units_lng.*
    FROM course_units, course_units_lng
    WHERE course_units.course_id = :course_id
    AND course_units.id = course_units_lng.unit_id
    AND course_units_lng.lang = (SELECT
    IFNULL( (SELECT lang FROM course_units_lng
    WHERE course_units_lng.unit_id = course_units.id AND course_units_lng.lang = :course_lang) ,
    course_units.default_lang))");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
}

$course_units = $stmt->fetchAll();

// get user progression
$stmt = $conn->prepare("SELECT user_id, unit_id, duration, points, given_name, family_name, users.email, organizations.name as affliation 
  FROM user_progression, course_units, users, organizations
  WHERE users.affiliation = organizations.id AND user_progression.unit_id = course_units.id AND course_units.course_id = :course_id AND user_progression.user_id = users.id");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);

if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
}

// extract users and progress
$user_data = array();
while($user_progression = $stmt->fetch()) {
  if (!array_key_exists($user_progression["user_id"], $user_data)) {
    $user_data[$user_progression["user_id"]] = array(
      "user_id" => $user_progression["user_id"],
      "given_name" => $user_progression["given_name"],
      "family_name" => $user_progression["family_name"],
      "email" => $user_progression["email"],
      "affliation" => $user_progression["affliation"],
      "units" => array(),
      "quizzes" => array(),
      "total_unit_progress" => "0%",
      "total_quizzes_progress" => "0%",
    );
  }

  $user_progress = "--";
  if($user_progression["points"] != 0){
    $user_progress = round($user_progression["duration"] / ($user_progression["points"] * $point_to_time_factor) * 100);
    ($user_progress>100)?$user_progress="100": $user_progress;
  }

  $user_data[$user_progression["user_id"]]["units"][$user_progression["unit_id"]] = array(
    "unit_id" => $user_progression["unit_id"],
    "actual_time" => $user_progression["duration"],
    "target_time" => $user_progression["points"] * 1,
    "progress" => $user_progress
  );
}

// quiz progress
foreach ($user_data as $key => &$value) {
  $stmt = $conn->prepare(
    "SELECT course_units.id AS unit_id,
          (SELECT COUNT(*) FROM course_elements, widget_data_quiz_questions
              WHERE widget_data_quiz_questions.element_id = course_elements.id
              AND course_elements.unit_id = course_units.id) AS total_questions,
          (SELECT COUNT(*) FROM course_elements, widget_data_quiz_questions, widget_data_quiz_submissions
              WHERE widget_data_quiz_questions.element_id = course_elements.id
              AND course_elements.unit_id = course_units.id
              AND widget_data_quiz_questions.id = widget_data_quiz_submissions.question_id
              AND widget_data_quiz_submissions.user_id = :user_id) AS submissions,
          (SELECT COUNT(*) FROM course_elements, widget_data_quiz_questions, widget_data_quiz_submissions, widget_data_quiz_answers, widget_data_quiz_submissions_answers
              WHERE widget_data_quiz_questions.element_id = course_elements.id
              AND course_elements.unit_id = course_units.id
              AND widget_data_quiz_questions.id = widget_data_quiz_submissions.question_id
              AND widget_data_quiz_submissions.user_id = :user_id
              AND widget_data_quiz_answers.question_id = widget_data_quiz_questions.id
              AND widget_data_quiz_submissions_answers.answer_id = widget_data_quiz_answers.id
              AND widget_data_quiz_answers.correct = widget_data_quiz_submissions_answers.checked
              AND widget_data_quiz_submissions_answers.user_id = :user_id
            ) AS correct,
            (SELECT COUNT(*) FROM course_elements, widget_data_quiz_questions, widget_data_quiz_submissions, widget_data_quiz_answers, widget_data_quiz_submissions_answers
                WHERE widget_data_quiz_questions.element_id = course_elements.id
                AND course_elements.unit_id = course_units.id
                AND widget_data_quiz_questions.id = widget_data_quiz_submissions.question_id
                AND widget_data_quiz_submissions.user_id = :user_id
                AND widget_data_quiz_answers.question_id = widget_data_quiz_questions.id
                AND widget_data_quiz_submissions_answers.answer_id = widget_data_quiz_answers.id
                AND widget_data_quiz_submissions_answers.user_id = :user_id
              ) AS answers
      FROM course_units
      WHERE course_units.course_id = :course_id
    ");
  $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
  $stmt->bindParam(":user_id", $value['user_id'], PDO::PARAM_INT);
  if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
  }

  while ($quiz_progress = $stmt->fetch()) {
    $value["quizzes"][$quiz_progress['unit_id']] = array(
      "unit_id" => $quiz_progress["unit_id"],
      "total_questions" => $quiz_progress["total_questions"],
      "submissions" => $quiz_progress["submissions"],
      "progress" => ($quiz_progress["total_questions"] == 0) ? "--" : round($quiz_progress["submissions"] / $quiz_progress["total_questions"] * 100). "%",
      "correct" => ($quiz_progress["total_questions"] == 0) ? "--" : $quiz_progress["correct"].'/'.$quiz_progress["answers"]
    );
  }
}

// total course progress (per user)
foreach ($user_data as $key => &$value) {
  $total_actual_time = 0;
  $total_target_time = 0;
  foreach ($course_units as $key1 => $value1) {
    $target_time = $value1["points"] * $point_to_time_factor;
    $actual_time = array_key_exists($value1["unit_id"], $value["units"]) ? $value["units"][$value1["unit_id"]]["actual_time"] : 0;
    $total_actual_time += $actual_time > $target_time ? $target_time : $actual_time;
    $total_target_time += $target_time;
  }
  $value["total_unit_progress"] = ($total_target_time == 0) ? "--" : round($total_actual_time / ($total_target_time * $point_to_time_factor) * 100). "%";

  $total_questions = 0;
  $total_submissons = 0;
  foreach ($value["quizzes"] as $key1 => $value1) {
    $total_submissons += $value1["submissions"];
    $total_questions += $value1["total_questions"];
  }
  $value["total_quizzes_progress"] = ($total_questions == 0) ? "--" : round($total_submissons / $total_questions * 100). "%";
}

?>

<p>

                    <?php echo $user_update_notice;
                    //DEBUG print_r($_SESSION);

                    ?>

                    <form id="fsearch" role="search">
                        <div class="row">
                            <input id="searchString" name="searched" type="text" class="form-control"
                                   placeholder="<?php
                echo getTranslation("usermanagement:search", "Search by");
                ?>"
                                   onkeyup="selectFilter();" style="width:150px;float:left;">
                                   <select name='searchType' id="searchType" onchange="selectFilter()" style="margin-left: 3px;">
                                       <option value="0">Name</option>
                                       <option value="1">Email</option>
                                       <option value="4">Affliation</option>
                                   </select>
                                   <div style="display:inline;margin-left: 3px;"><div id="userCount" style="display:inline;"><strong><?php echo sizeof($user_data) ?></strong></div> participants</div>
                            <br/>
                        </div>
                    </form><br>
                    Sort By: <a href="#" onclick="sortDivs('0');">Name</a> | <a href="#" onclick="sortDivs('1');">Email</a> | <a href="#" onclick="sortDivs('4');">Affliation</a>
</p>
<div class="list-group list-group-root well" id="userlist">
  <?php foreach ($user_data as $value1): ?>
    <div class="userlistitem">
    <a href="#item-<?php echo $value1['user_id'] ?>" class="list-group-item useritem" data-toggle="collapse">
      <input type="hidden" name="name" value="<?php echo $value1['family_name'].', '.$value1['given_name'] ?>"\>
      <input type="hidden" name="email" value="<?php echo $value1['email'] ?>"\>
      <input type="hidden" name="affliation" value="<?php echo $value1['affliation'] ?>"\>
      <?php echo $value1['family_name'] ?>, <?php echo $value1['given_name'] ?> (<?php echo $value1['email']; ?>)
      <span class="pull-right">
          <span class="glyphicon glyphicon-time margin-right margin-left"></span>
          <?php echo $value1['total_unit_progress'] ?>
          <span class="glyphicon glyphicon-question-sign margin-right margin-left"></span>
          <?php echo $value1['total_quizzes_progress'] ?>
      </span>
    </a>
    <div class="list-group collapse" id="item-<?php echo $value1['user_id'] ?>">
      <?php foreach ($course_units as $unitkey => $unit): ?>
        <a href="#quizz-<?php echo $value1['user_id'].'-'.$unit['unit_id'] ?>" class="list-group-item" data-toggle="collapse">
          <?php echo $unit['title'] ?>
          <span class="pull-right">
            <span class="glyphicon glyphicon-time margin-right margin-left"></span>
            <?php echo (isset($value1['units'][$unit['unit_id']]['progress']))? $value1['units'][$unit['unit_id']]['progress']."%" : "--"; ?>
            <span class="glyphicon glyphicon-question-sign margin-right margin-left"></span>
            <?php echo $value1['quizzes'][$unit['unit_id']]['progress'] ?>
            <span class="glyphicon glyphicon-ok margin-right margin-left"></span>
            <?php echo $value1['quizzes'][$unit['unit_id']]['correct'] ?>
          </span>
        </a>
        <div class="list-group collapse" id="quizz-<?php echo $value1['user_id'].'-'.$unit['unit_id'] ?>">
          <a href="#" class="list-group-item">
            <table style="vertical-align: top">
              <?php
                // compute all questions
                $stmt = $conn->prepare(
                  "SELECT widget_data_quiz_questions_lng.title as title,
                          GROUP_CONCAT(widget_data_quiz_answers_lng.title SEPARATOR '|||') as questions,
                          GROUP_CONCAT(widget_data_quiz_submissions_answers.checked SEPARATOR '|||') as checked,
                          GROUP_CONCAT(widget_data_quiz_answers.correct SEPARATOR '|||') as correct
                    FROM course_elements
                    INNER JOIN widget_data_quiz_questions on widget_data_quiz_questions.element_id = course_elements.id
                    INNER JOIN widget_data_quiz_questions_lng on widget_data_quiz_questions.id = widget_data_quiz_questions_lng.question_id
                    INNER JOIN widget_data_quiz_answers on widget_data_quiz_answers.question_id = widget_data_quiz_questions.id
                    INNER JOIN widget_data_quiz_answers_lng on widget_data_quiz_answers_lng.answer_id = widget_data_quiz_answers.id
                    INNER JOIN widget_data_quiz_submissions_answers on widget_data_quiz_submissions_answers.answer_id = widget_data_quiz_answers.id
                    WHERE course_elements.unit_id = :unit_id and
                          widget_data_quiz_questions_lng.lang = 'en' and
                          widget_data_quiz_answers_lng.lang = 'en' and
                          widget_data_quiz_submissions_answers.user_id = :user_id
                    GROUP BY widget_data_quiz_questions_lng.title
                  ");
                $stmt->bindParam(":unit_id", $unit['unit_id'], PDO::PARAM_INT);
                $stmt->bindParam(":user_id", $value1['user_id'], PDO::PARAM_INT);
                $stmt->execute();
                while ($quiz = $stmt->fetch()): ?>
                  <tr>
                    <th colspan="12"><h4><?php print $quiz["title"] ?></h4></th>

                  </tr>
                  <tr>
                    <?php
                      $questions = explode("|||", $quiz["questions"]);
                      $checked = explode("|||", $quiz["checked"]);
                      $correct = explode("|||", $quiz["correct"]);
                      foreach ($questions as $i => $question): ?>
                        <td style="color: <?php if ($correct[$i]) { print 'green'; } else { print 'red'; } ?>">
                          <input type="checkbox" <?php if ($checked[$i]) { print 'checked'; } ?> disabled />
                          <?php print $question ?></td>
                    <?php endforeach; ?>
                  </tr>
                <?php endwhile;
              ?>
            </table>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
  function selectFilter(){
    var el = document.getElementById('searchType');
    var i = el.options[el.selectedIndex].value;
    filter(i);
    var rows = document.getElementsByClassName("useritem").length;
    var hidden = $('.useritem').filter(":hidden").size();
    $("#userCount").html(rows-hidden); 
  }

  function filter(type){
    var x = document.getElementsByClassName("useritem");
    for (i = 0; i < x.length; i++) {
      $(x[i]).show();
      if(type==0){
              var inputs = $(x[i]).find("input[name='name']");
              var searchInput = document.getElementById("searchString");
              if(inputs[0].value.toLowerCase().indexOf(searchInput.value.toLowerCase()) == -1){
                $(x[i]).hide();
              }
      }else if(type==1){
              var inputs = $(x[i]).find("input[name='email']");
              var searchInput = document.getElementById("searchString");
              if(inputs[0].value.toLowerCase().indexOf(searchInput.value.toLowerCase()) == -1){
                $(x[i]).hide();
              }
      }else if(type==4){
              var inputs = $(x[i]).find("input[name='affliation']");
              var searchInput = document.getElementById("searchString");
              if(inputs[0].value.toLowerCase().indexOf(searchInput.value.toLowerCase()) == -1){
                $(x[i]).hide();
              }
      }else{
              var inputs = $(x[i]).find("input[name='name']"); 
              var searchInput = document.getElementById("searchString");
              if(inputs[0].value.toLowerCase().indexOf(searchInput.value.toLowerCase()) == -1){
                $(x[i]).hide();
              }
      }
    }
  }

  var lastSortN = false;
  var lastSortE = false;
  var lastSortA = false;

  function sortDivs(type){
    var userlist = $('div .userlistitem');
    var res = $(userlist).sort(function (a, b) {
      if(type==0){
        var contentA = $(a).find("input[name='name']").val(); 
        var contentB = $(b).find("input[name='name']").val(); 
        var t = (contentA.localeCompare(contentB));
        if(lastSortN){
          t  = t*-1;
        }
        return t;
      }else if(type==1){
        var contentA = $(a).find("input[name='email']").val(); 
        var contentB = $(b).find("input[name='email']").val(); 
        var t = (contentA.localeCompare(contentB));
        if(lastSortE){
          t  = t*-1;
        }
        return t;
      }else if(type==4){
        var contentA = $(a).find("input[name='affliation']").val(); 
        var contentB = $(b).find("input[name='affliation']").val(); 

        var contentAA = $(a).find("input[name='name']").val(); 
        var contentBB = $(b).find("input[name='name']").val(); 
        var t = (contentA.localeCompare(contentB));
        if(lastSortA){
          t  = t*-1;
        }
        if (t==0) return (contentAA.localeCompare(contentBB));
        return t;
      }else{
        var contentA = $(a).find("input[name='name']").val(); 
        var contentB = $(b).find("input[name='name']").val(); 
        return (contentA.localeCompare(contentB));
      }
      
   });
  if(type==0){
    if(lastSortN){
      lastSortN = false;
    }else{
      lastSortN = true;
    }
  }else if(type==1){
    if(lastSortE){
      lastSortE = false;
    }else{
      lastSortE = true;
    }
  }else if(type==4){
    if(lastSortA){
      lastSortA = false;
    }else{
      lastSortA = true;
    }
  }
  $("#userlist").html(res);
  }
</script>


