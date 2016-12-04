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
// Get course data and name + email of its creator from our database based
// on the id given in the website URL
include '../php/db_connect.php';
include '../php/tools.php';

$arg = $_GET["id"];
$query = $db->query("SELECT courses.*, users.given_name, users.family_name, users.email FROM courses JOIN users ON courses.creator = users.id WHERE courses.id = $arg");

$entry = $query->fetchObject();

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

//TODO: get course units from DB.
$course_units = array();
$course_units[0]["id"] = "1";
$course_units[0]["title"] = "unit1";
$course_units[0]["start_date"] = "01.11.2016";
$course_units[0]["description"] = "01.11.2016";

$course_units[1]["id"] = "2";
$course_units[1]["title"] = "unit2";
$course_units[1]["start_date"] = "07.11.2016";
$course_units[1]["description"] = "01.11.2016";

$course_units[2]["id"] = "3";
$course_units[2]["title"] = "unit3";
$course_units[2]["start_date"] = "14.11.2016";
$course_units[2]["description"] = "01.11.2016";

$course_units[3]["id"] = "4";
$course_units[3]["title"] = "unit4";
$course_units[3]["start_date"] = "21.11.2016";
$course_units[3]["description"] = "01.11.2016";

$course_units[4]["id"] = "5";
$course_units[4]["title"] = "unit5";
$course_units[4]["start_date"] = "28.11.2016";
$course_units[4]["description"] = "01.11.2016";

?>
<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php echo "$entry->name"; ?></h1>
        </div>
    </div>
</header>

<div id='courses'>
    <section class='container'>
        <br><br>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12 non-overflow-div'>
                    <div class="col-sm-12">
                        <?php if (!(filter_input(INPUT_GET, "widget") == "true")) { ?>
                            <a id="enter-course-a" href="#" data-rolespace="<?php echo $entry->role_url; ?>">
                                <button class='btn btn-success btn-lg btn-block' type='button'>Enter course room
                                </button>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="col-xs-12 margin-top">
                        <?php foreach($course_units as $course_unit): ?>
                        <ul class="list-group">
                            <li data-toggle="collapse" data-target="#<?php echo $course_unit["id"] ?>" href="#" class="hover-click list-group-item clearfix">
                                <span class="glyphicon glyphicon-book margin-right"></span>
                                <?php echo $course_unit["title"] ?>
                                <span class="pull-right">
                                    <span class="glyphicon glyphicon-calendar margin-right"></span>
                                    <?php echo $course_unit["start_date"] ?>
                                    <!-- TODO: href to course room-->
                                    <a href="#" class="margin-left btn btn-xs btn-warning">
                                        Enter Course Room
                                    </a>
                                </span>
                            </li>
                            <div id="<?php echo $course_unit["id"] ?>" class="collapse">
                                <div class="margin-top margin-left">
                                    <?php echo $course_unit["description"] ?>
                                </div>

                            </div>
                        </ul>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-xs-12 margin-top">
                        <label class="col-sm-3">Created by:</label>
                        <p class="col-sm-3 output-element"><?php echo $entry->given_name . " " . $entry->family_name; ?></p>
                        <a href="mailto:<?php echo $entry->email; ?>"><?php echo $entry->email; ?></a>
                    </div>
                    <div class="col-xs-12">
                        <label class="col-sm-3">Domain:</label>
                        <p class="col-sm-9 output-element"><?php echo $entry->domain; ?></p>
                    </div>

                    <div class="col-xs-12">
                        <label class="col-sm-3">Profession:</label>
                        <p class="col-sm-9 output-element"><?php echo $entry->profession; ?></p>
                    </div>
                    <!--<div class="col-xs-12">
                        <label class="col-sm-3">Contact:</label>
                        <p class="col-sm-9 output-element"><?php echo $entry->contact; ?></p>
                    </div>-->
                    <div class="col-xs-12">
                        <label class="col-sm-3">Description:</label>
                        <p class="col-sm-9 output-element"><?php echo $entry->description; ?></p>
                    </div>
                    <!--<div class="col-xs-12">
                        <label class="col-sm-3">Dates:</label>
                        <p class="col-sm-9 output-element"><?php echo $entry->dates; ?></p>
                    </div>-->
                    <!--<div class="col-xs-12">
                        <label class="col-sm-3">Links:</label>
                        <p class="col-sm-9 output-element"><?php echo replaceLinks($entry->links); ?></p>
                    </div>-->
                </div>
                <div class="col-sm-12 middle-btn-div">
                    <div class=" col-sm-5">
                        <?php printLinkBtn("editcourse.php?id=$arg",
                            "btn btn-success btn-block btn-lg middle-btn-margin", "Edit"); ?>
                    </div>
                    <div class="col-sm-5">
                        <button class="btn btn-warning col-sm-5 btn-block btn-lg middle-btn-margin" type='button'
                                id="btn-delete">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- container -->

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
