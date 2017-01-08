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
$conn = require '../php/db_connect.php';
include '../php/tools.php';

// The course unit id from URL parameter
$course_id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$course_lang = "en";  // default value
if (isset($_GET["lang"])) {
    $course_lang = filter_input(INPUT_GET, "lang");
}

// Gets course details with it's creator information
$stmt = $conn->prepare("SELECT courses.*, organizations.name AS orga, organizations.email AS orga_email 
          FROM courses 
          JOIN organizations 
            ON courses.creator = organizations.email 
          WHERE courses.id = :course_id
            AND courses.lang = :course_lang
          LIMIT 1");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if (!$success) {
    echo "Error loading course.";
} else {
    $course_details = $stmt->fetch();
}

// Get course subject
$course_subject_details = $conn->query("SELECT subjects.* FROM subjects WHERE id= $course_id")->fetch(PDO::FETCH_ASSOC);


// Get course units
$stmt = $conn->prepare("SELECT course_units.*
                        FROM courses 
                        JOIN course_to_unit 
                        ON courses.id = course_to_unit.course_id 
                          AND courses.lang = course_to_unit.course_lang
                        JOIN course_units 
                        ON course_to_unit.unit_id = course_units.id 
                          AND course_to_unit.unit_lang = course_units.lang
                        WHERE courses.id = :course_id
                          AND course_units.lang = :course_lang");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if ($success) {
    $course_units = $stmt->fetchAll();
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
                                    <a href="http://role-sandbox.eu/spaces/v3c_demo" target="_blank" class="margin-left btn btn-xs btn-warning">
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
