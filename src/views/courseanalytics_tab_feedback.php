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

// get active users
$stmt = $conn->prepare("SELECT user_id, unit_id, given_name, family_name, users.email, organizations.name as affliation
  FROM user_progression, course_units, users, organizations
  WHERE users.affiliation = organizations.id AND user_progression.unit_id = course_units.id AND course_units.course_id = :course_id AND user_progression.user_id = users.id");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);

if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
}

// extract users
$user_data = array();
while($user_progression = $stmt->fetch()) {
  if (!array_key_exists($user_progression["user_id"], $user_data)) {
    $user_data[$user_progression["user_id"]] = array(
      "user_id" => $user_progression["user_id"],
      "given_name" => $user_progression["given_name"],
      "family_name" => $user_progression["family_name"],
      "email" => $user_progression["email"],
      "affliation" => $user_progression["affliation"],
      "submissions" => array(),
    );
  }
}

// submissions
foreach ($user_data as $key => &$value) {
  $stmt = $conn->prepare(
    "SELECT course_units.id AS unit_id, course_elements.id AS element_id, widget_data_feedback_submissions.content AS content, widget_data_feedback_lng.title AS title
      FROM course_units, course_elements, widget_data_feedback_submissions, widget_data_feedback_lng
      WHERE course_units.course_id = :course_id
        AND course_elements.unit_id = course_units.id
        AND widget_data_feedback_submissions.element_id = course_elements.id
        AND widget_data_feedback_submissions.user_id = :user_id
        AND widget_data_feedback_lng.element_id = course_elements.id
        AND widget_data_feedback_lng.lang = course_elements.default_lang
    ");
  $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
  $stmt->bindParam(":user_id", $value['user_id'], PDO::PARAM_INT);
  if (!$stmt->execute()) {
    print_r( $stmt->errorInfo() );
    die();
  }

  foreach ($course_units as $unitkey => $unit) {
    $value["submissions"][$unit['unit_id']] = array();
  }

  while ($data = $stmt->fetch()) {
    $value["submissions"][$data['unit_id']][$data['element_id']] = array(
      "title" => $data['title'],
      "content" => $data['content']
    );
  }
}

?>

<p>
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
    </a>
    <div class="list-group collapse" id="item-<?php echo $value1['user_id'] ?>">
      <?php foreach ($course_units as $unitkey => $unit): ?>
        <a href="#item-<?php echo $value1['user_id'] ?>-<?php echo $unit['unit_id'] ?>" class="list-group-item" data-toggle="collapse">
          <?php echo $unit['title'] ?>
        </a>
        <div class="list-group collapse" id="item-<?php echo $value1['user_id'] ?>-<?php echo $unit['unit_id'] ?>">
          <?php foreach ($value1['submissions'][$unit['unit_id']] as $elementkey => $element): ?>
            <a href="#" class="list-group-item">
              <b><?php echo $element['title'] ?></b><br />
              <textarea readonly><?php echo $element['content'] ?></textarea>
            </a>
          <?php endforeach; ?>
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