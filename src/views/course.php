<?php
/**
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @file course.php
 * Webpage for viewing a single course
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V3C</title>
</head>

<body>
<?php include("menu.php"); ?>

<?php
include '../php/db_connect.php';
include '../php/tools.php';

// The course unit id from URL parameter
$course_id = $_GET["id"];

// Gets course details with it's creator information
$course_query = $db->query("SELECT courses.*, users.given_name, users.family_name, users.email 
                            FROM courses JOIN users ON courses.creator = users.email 
                            WHERE courses.id = $course_id");
$course_details = $course_query->fetchObject();

// Get course subject
$course_subject_details = $db->query("SELECT subjects.* FROM subjects WHERE id= $course_id")->fetch(PDO::FETCH_ASSOC);

// Gets the course units that correspond the particular course
$course_units = $db->query("SELECT DISTINCT course_units.* 
                            FROM course_units JOIN course_to_unit AS ctu ON ctu.course_id = $course_id")->fetchAll();
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
            <h1><?php echo "$course_details->name"; ?></h1>
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
                            <h2>Course Units</h2>
                            <!--<?php if (!(filter_input(INPUT_GET, "widget") == "true")) { ?>
                                <a id="enter-course-a" href="#" data-rolespace="<?php echo $course_details->role_url; ?>">
                                    <button class='btn btn-success btn-lg btn-block' type='button'>Enter course room
                                    </button>
                                </a>
                            <?php } ?>-->
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
                                        Enter Course Room
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
                        <label class="col-sm-3 output-element">Created by:</label>
                        <div class="col-sm-7"><?php echo $course_details->given_name . " " . $course_details->family_name; ?>
                            (<a href="mailto:<?php echo $course_details->email; ?>"><?php echo $course_details->email; ?></a>)</div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <label class="col-sm-3">Domain:</label>
                        <p class="col-sm-7 output-element"><?php echo $course_subject_details["name"]; ?></p>
                        <div class="col-sm-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-1"></div>
                        <label class="col-sm-3">Profession:</label>
                        <p class="col-sm-7 output-element"><?php echo $course_details->profession; ?></p>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <label class="col-sm-3">Description:</label>
                        <p class="col-sm-7 output-element"><?php echo $course_details->description; ?></p>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class=" col-sm-5">
                            <?php printLinkBtn("editcourse.php?id=$course_id",
                                "btn btn-success btn-block btn-lg", "Edit"); ?>
                        </div>
                        <div class="col-sm-5">
                            <button class="btn btn-warning col-sm-5 btn-block btn-lg " type='button'
                                    id="btn-delete">Delete
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
<?php
//Decide if this site is inside a separate widget
if (filter_input(INPUT_GET, "widget") == "true") {
    print("<script src='../js/overview-widget.js'> </script>");
}
?>
<script type="text/javascript" src="../js/course.js"></script>
</body>
</html>
