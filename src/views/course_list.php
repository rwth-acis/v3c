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
 * @file course_delete.php
 * Webpage for deleting a single course
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses | V3C</title>

    <link rel="stylesheet" href="../external/jasny-bootstrap/dist/css/jasny-bootstrap.min.css"/>
</head>

<body>
<?php include("menu.php"); ?>

<?php
// Get all course data and name + email of their creators from our database based
// on the subject id given in the website URL
include '../php/db_connect.php';
include '../php/tools.php';

$subject_id = filter_input(INPUT_GET, "id");
$subject = $db->query("SELECT * FROM subjects WHERE id='$subject_id'")->fetchObject();
$courses = $db->query("SELECT courses.*, organizations.name AS orga, organizations.email AS orga_email 
                           FROM courses JOIN organizations ON courses.creator=organizations.email 
                           WHERE courses.domain='$subject_id' ORDER BY id ASC")->fetchAll();

?>
<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php echo "$subject->name courses"; ?></h1>
        </div>
    </div>
</header>

<div id='courses'>
    <section class='container'>
        <div class='container'>
            <div class='row'>
                <!-- Info box with data about subject -->
                <div class='col-sm-4'>
                    <div class='featured-box'>
                        <img src="<?php echo "$subject->img_url" ?>">
                        <?php if (!(filter_input(INPUT_GET, "widget") == "true")) { ?>
                            <a href="addcourse.php?id=<?php echo $subject->id; ?>">
                                <button class='btn btn-success btn-lg btn-block margin-top' type='button'>Add new
                                    course
                                </button>
                            </a>
                        <?php } ?>
                    </div>
                </div>


                <div class="row col-sm-8">
                    <form id="fsearch" class="navbar-form navbar-left" role="search">
                        <div class="row">
                            <div class="row col-sm-6">
                                <select class="form-control" name="lang" id="lang_dropdown" onchange="filter()">
                                    <?php
                                    $languages = array(
                                        "en" => "English",
                                        "de" => "Deutsch",
                                        "es" => "Español",
                                        "it" => "Italiano",
                                        "gr" => "ελληνικά",
                                        "all" => "All Courses"
                                    );
                                    foreach ($languages as $code => $language) {
                                        echo $_SESSION["lang"];
                                        $selected = ($_SESSION["lang"] == $code) ? "selected" : "";

                                        echo "<option class='flag flag-$code' value='$code' $selected>$language</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row col-sm-6">
                                <input id ="searchString" name="searched" type="text" class="form-control" placeholder="Search"
                                       onkeyup="filter()">
                                <br/>
                            </div>
                        </div>
                        <input hidden id="subject_input" name="subject_id" value=<?php echo $subject_id; ?>>
                    </form>
                </div>

                <!-- List of all courses -->
                <div class='col-sm-8'>
                    <h3>Choose course</h3>
                    <div id="course_table">
                        <table id="courseTable" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Course name</th>
                                <th>Created by</th>
                                <th>Start Dates</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody data-link="row" class="rowlink">
                            <?php
                            $index = 0;
                            for ($cntr = 0; $cntr < count($courses); $cntr++) {
                                $initCntr = $cntr;
                                $lang_array = array($courses[$cntr]["lang"]);
                                while ($cntr < count($courses)-1) {
                                    if ($courses[$cntr]["id"] == $courses[$cntr + 1]["id"]) {
                                        array_push($lang_array, $courses[$cntr + 1]["lang"]);
                                        $cntr++;
                                    } else {
                                        break;
                                    }
                                }
                                // Add line brake after each date for more readability in the table
                                $course_dates_array = explode("\n", $courses[$initCntr]["date_created"]);
                                $index++;

                                ?>
                                <tr>
                                    <td>
                                        <a href="course.php?id=<?php echo $courses[$initCntr]["id"] . "&lang=" . $courses[$initCntr]["lang"]; ?>"><?php echo $courses[$initCntr]["name"]; ?></a>
                                    </td>
                                    <td><?php echo $courses[$initCntr]["orga"]; ?></td>
                                    <td><?php foreach ($course_dates_array as $start_date) {
                                            echo $start_date . "<br>";
                                        } ?></td>
                                    <td class="language-flag-rows">
                                        <?php $i=0; foreach ($lang_array as $c_lang) {
                                            ?>
                                            <input hidden value=<?php echo $c_lang; ?>>
                                            <a href="course.php?id=<?php echo $courses[$initCntr]["id"] . "&lang=" . $c_lang ?>">
                                            <img class="language-flag-element language-flag-onhover <?php if($i==0){?>language-flag-active<?php } ?>"
                                                 src="<?php echo "../images/flags/s_" . $c_lang . ".png" ?>">
                                            </a>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </td>
                                    <td class="rowlink-skip"><input type="button"
                                                                    data-id="<?php echo $courses[$initCntr]["id"]; ?>"
                                                                    class="btn btn-edit btn-sm btn-success btn-block"
                                                                    value="Edit"/></td>
                                    <td class="rowlink-skip"><input type="button"
                                                                    data-id="<?php echo $courses[$initCntr]["id"]; ?>"
                                                                    class="btn btn-delete btn-sm btn-warning btn-block"
                                                                    value="Delete"></td>
                                </tr>
                                <tr>
                                    <!-- Collapse div for course description -->
                                    <td colspan="6">
                                        <button type="button" class="btn btn-info" data-toggle="collapse"
                                                data-target="#description-<?php echo $index; ?>">Description
                                        </button>
                                        <div id="description-<?php echo $index; ?>" class="collapse">
                                            <?php echo $courses[$initCntr]["description"]; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- container -->

<?php include("footer.php"); ?>

<script type="text/javascript" src="../js/tools.js"></script>
<?php
//Decide if this site is inside a separate widget
if (filter_input(INPUT_GET, "widget") == "true") {
    print("<script src='../js/overview-widget.js'> </script>");
}
?>
<!-- Library which defines behavior of the <table class="table table-striped table-bordered table-hover"> -->
<script src="../external/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="../js/course-list.js"></script>
<script src="../js/search-course.js"></script>
<script src="../js/filter-courses.js"></script>
</body>
</html>
