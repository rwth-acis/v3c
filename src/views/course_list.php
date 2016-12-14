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
                           WHERE courses.domain='$subject_id'")->fetchAll();

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

                <!-- List of all courses -->
                <div class='col-sm-8'>
                    <form id ="fsearch" class="navbar-form navbar-left" role="search">
                        <div class="form-group">

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <select name="lang" id="lang_dropdown" onchange="filter()">
                                        <option value="en">English</option>
                                        <option value="de">Deutsch</option>
                                        <option value="es">Español</option>
                                        <option value="it">Italiano</option>
                                        <option value="gr">Eλληνικά</option>
                                    </select>
                                </div>
                            </div>

                            <input name= "searched" type="text" class="form-control" placeholder="Search" onkeyup = "search()">

                            <input hidden id="subject_input" name="subject_id" value=<?php echo $subject_id; ?>>

                        </div>
                    </form>
                    <br>
                    <h3>Choose course</h3>
                    <div id ="course_table">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Course name</th>
                                <th>Created by</th>
                                <th>Start Dates</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody data-link="row" class="rowlink">
                            <?php
                            $index = 0;
                            foreach ($courses as $course) {
                                // Add line brake after each date for more readability in the table
                                $course_dates_array = explode("\n", $course["date_created"]);
                                $index++;
                                ?>
                                <tr>
                                    <td>
                                        <a href="course.php?id=<?php echo $course["id"] . "&lang=" . $course["lang"]; ?>"><?php echo $course["name"]; ?></a>
                                    </td>
                                    <td><?php echo $course["orga"]; ?></td>
                                    <td><?php foreach ($course_dates_array as $start_date) {
                                            echo $start_date . "<br>";
                                        } ?></td>
                                    <td class="language-flag-rows"><img class="language-flag-element" src="<?php echo "../images/flags/s_".$course["lang"].".png"?>"></td>
                                    <td class="rowlink-skip"><input type="button" data-id="<?php echo $course["id"]; ?>"
                                                                    class="btn btn-edit btn-sm btn-success btn-block"
                                                                    value="Edit"/></td>
                                    <td class="rowlink-skip"><input type="button" data-id="<?php echo $course["id"]; ?>"
                                                                    class="btn btn-delete btn-sm btn-warning btn-block"
                                                                    value="Delete"></td>
                                </tr>
                                <tr>
                                    <!-- Collapse div for course description -->
                                    <td colspan="5">
                                        <button type="button" class="btn btn-info" data-toggle="collapse"
                                                data-target="#description-<?php echo $index; ?>">Description
                                        </button>
                                        <div id="description-<?php echo $index; ?>" class="collapse">
                                            <?php echo $course["description"]; ?>
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
