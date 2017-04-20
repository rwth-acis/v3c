<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V3C</title>
</head>

<body>
    <?php include("menu.php"); ?>

    <?php
    $conn = require_once '../php/db_connect.php';
    include '../php/tools.php';
    include '../php/access_control.php';
    $accessControl = new AccessControl();


// The course unit id from URL parameter
    $course_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$course_lang = "en";  // default value
if (isset($_GET["lang"])) {
    $course_lang = filter_input(INPUT_GET, "lang");
}

$isLecturer = $accessControl->canUpdateCourse($course_id);


// Gets course details with it's creator information
$stmt = $conn->prepare("SELECT courses.*, courses_lng.*, organizations.name AS orga, organizations.email AS orga_email
  FROM courses, organizations, courses_lng
  WHERE courses.id = :course_id
  AND courses.creator = organizations.email
  AND courses_lng.course_id = courses.id
  AND (courses_lng.lang = :course_lang OR courses_lng.lang = (SELECT default_lang FROM courses WHERE id = :course_id))
  ");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if (!$success) {
    echo "Error loading course.";
} else {
    $course_details = $stmt->fetchAll();
    if (sizeof($course_details) == 1 || $course_details[0]['lang'] == $course_lang) {
      $course_details = $course_details[0];
  }
  else {
      $course_details = $course_details[1];
  }
}

// Get course subject
$course_domain = $course_details["domain"];
$course_subject_details = $conn->query("SELECT subjects.* FROM subjects WHERE id= $course_domain")->fetch(PDO::FETCH_ASSOC);


// Get course units
$stmt = $conn->prepare("SELECT course_units.*, course_units_lng.*
    FROM course_units, course_units_lng
    WHERE course_units.course_id = :course_id
    AND course_units.id = course_units_lng.unit_id
    AND course_units_lng.lang = (SELECT
    IFNULL( (SELECT lang FROM course_units_lng
    WHERE course_units_lng.unit_id = course_units.id AND course_units_lng.lang = :course_lang) ,
    course_units.default_lang))
                        ");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if ($success) {
    $course_units = $stmt->fetchAll();
}
else {
  print_r( $stmt->errorInfo() );
}
/**
 * Replaces all URLs in the given text by <a> tags
 * Taken from https://css-tricks.com/snippets/php/find-urls-in-text-make-links/
 * @param String $text
 * @return String
 */
function replaceLinks($text)
{
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    preg_match_all($reg_exUrl, $text, $matches);
    $usedPatterns = array();
    foreach ($matches[0] as $pattern) {
        if (!array_key_exists($pattern, $usedPatterns)) {
            $usedPatterns[$pattern] = true;
            $text = str_replace($pattern, "<a href=\"$pattern\" rel=\"nofollow\">$pattern</a>", $text);
        }
    }
    return $text;
}

?>
<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php echo $course_details["name"]; ?></h1>
        </div>
    </div>
</header>

<div id='courses'>
    <section class='container'>
        <br><br>
        <!-- This container is divided in three rows: The Title, The Course Units and Course meta data -->
        <div class='container'>
            <!-- Course Title -->
            <div class='row'>
                <div class='col-md-12 non-overflow-div'>
                    <div class="row">
                        <div class='col-md-12 text-center'>
                            <h2><?php echo getTranslation("course:content:courseunits", "Course Units");?></h2>
                        </div>
                    </div>
                    <!-- Course Units -->
                    <div class="row">
                        <div class="col-xs-12 margin-top">
                            <ul class="list-group">
                                <!-- List element for each course unit is created -->
                                <?php foreach($course_units as $course_unit):?>
                                    <li data-toggle="collapse" data-target="#<?php echo $course_unit["id"] ?>" href="#" class="hover-click list-group-item clearfix">
                                        <span class="glyphicon glyphicon-book margin-right"></span>
                                        <?php echo $course_unit["title"] ?>
                                        <span class="pull-right">
                                            <span class="glyphicon glyphicon-calendar margin-right"></span>
                                            <?php echo $course_unit["start_date"] ?>
                                            <!-- TODO: href to course room-->
                                            <a href="http://virtus-vet.eu:8081/spaces/<?php echo $course_details['space_url']; ?>#activity=<?php echo $course_unit["activity_url"]; ?>" target="_blank" class="margin-left btn btn-xs btn-warning">
                                                <?php echo getTranslation("course:content:enterroom", "Enter Course Room");?>
                                            </a>
                                        </span>
                                    </li>
                                    <div id="<?php echo $course_unit["id"] ?>" class="collapse">
                                        <div class="margin-top margin-left">
                                            <?php echo $course_unit["description"] ?>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse">
                                            <div class="panel-body">Panel Body</div>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Course metadata -->
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 non-overflow-div" style="margin: 0 auto;">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <label class="col-sm-3 output-element"><?php echo getTranslation("course:content:createdby", "Created by:");?></label>
                        <div class="col-sm-7"><?php echo $course_details["orga"]; ?>
                            (<a href="mailto:<?php echo $course_details["orga_email"]; ?>"><?php echo $course_details["orga_email"]; ?></a>)</div>
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <label class="col-sm-3"><?php echo getTranslation("course:content:domain", "Domain:");?></label>
                            <p class="col-sm-7 output-element"><?php echo $course_subject_details["name"]; ?></p>
                            <div class="col-sm-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-sm-1"></div>
                            <label class="col-sm-3"><?php echo getTranslation("course:content:profession", "Profession:");?></label>
                            <p class="col-sm-7 output-element"><?php echo $course_details["profession"]; ?></p>
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <label class="col-sm-3"><?php echo getTranslation("course:content:description", "Description:");?></label>
                            <p class="col-sm-7 output-element"><?php echo $course_details["description"]; ?></p>
                            <div class="col-sm-1"></div>
                        </div>
                        <?php if ($isLecturer) {
                            ?>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class=" col-sm-5">
                                    <?php printLinkBtn("editcourse.php?id=$course_id&lang=$course_lang",
                                    "btn btn-success btn-block btn-lg", getTranslation("general:button:edit", "Edit")) ?>
                                </div>
                                <div class="col-sm-5">
                                    <button class="btn btn-warning col-sm-5 btn-block btn-lg " type='button'
                                    id="btn-delete"><?php echo getTranslation("general:button:delete", "Delete");?>
                                </button>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </section>
        <!-- container -->
    </div>
    <!-- #courses -->

    <?php include("footer.php"); ?>

    <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="../js/tools.js"></script>
    <script type="text/javascript" src="../js/course.js"></script>

</body>
</html>
