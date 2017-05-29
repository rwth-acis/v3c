<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses | V3C</title>

    <link rel="stylesheet" href="../external/jasny-bootstrap/dist/css/jasny-bootstrap.min.css"/>
</head>

<body>
    <?php

    include("menu.php");

// Get all course data and name + email of their creators from our database based
// on the subject id given in the website URL
    include '../php/db_connect.php';
    require_once '../php/tools.php';
    require_once '../php/access_control.php';

    $accessControl = new AccessControl();
    $isLecturer = $accessControl->canCreateCourse();

    $subject_id = filter_input(INPUT_GET, "id");

    $subject = $db->query("SELECT * FROM subjects WHERE id='$subject_id'")->fetchObject();
    $courses = $db->query("SELECT courses.*, courses_lng.*, organizations.name AS orga, organizations.email AS orga_email
     FROM courses, organizations, courses_lng WHERE courses.creator=organizations.email
     AND courses.id = courses_lng.course_id
     AND courses.domain='$subject_id' ORDER BY id ASC")->fetchAll();

    $course_credits = $db->query("SELECT course_id, SUM(points) as credits FROM course_units GROUP BY course_id ORDER BY course_id ASC")->fetchAll();
    $course_start_date = $db->query("SELECT course_id, MIN(start_date) as start FROM course_units GROUP BY course_id")->fetchAll();
    $course_deletion_notice = "";
    if (isset($_GET["deleted"]) && $_GET["deleted"] == 1) {
        $course_deletion_notice = "<p class='alert alert-success'>Course was deleted successfully.</p>";
    }


    ?>

    <header id='head' class='secondary'>
        <div class='container'>
            <div class='row'>
                <h1><?php
                    echo  $subject->name . getTranslation("courselist:head:subcourses_tmp", " Courses");
                //echo template_substitution(getTranslation("courselist:head:subcourses", "{SUBJECT} Courses"), array("{SUBJECT}" => $subject->name));
                    ?></h1>
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
                                <?php if (!(filter_input(INPUT_GET, "widget") == "true") && $isLecturer) { ?>
                                <a href="addcourse.php?id=<?php echo $subject->id; ?>">
                                    <button class='btn btn-success btn-lg btn-block margin-top' type='button'>
                                        <?php echo getTranslation("courselist:head:add", "Add new course");?>
                                    </button>
                                </a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row col-sm-8">

                            <?php echo $course_deletion_notice; ?>

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
                                        <input id ="searchString" name="searched" type="text" class="form-control" placeholder="<?php echo getTranslation("courselist:head:search", "Search");?>"
                                        onkeyup="filter()">
                                        <br/>
                                    </div>
                                </div>
                                <input hidden id="subject_input" name="subject_id" value=<?php echo $subject_id; ?>>
                            </form>
                        </div>

                        <!-- List of all courses -->
                        <div class='col-sm-8'>
                            <h3><?php echo getTranslation("courselist:choose:choose", "Choose course");?></h3>
                            <div>
                                <table id="course-table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo getTranslation("courselist:choose:name", "Course name");?></th>
                                            <th><?php echo getTranslation("courselist:choose:creator", "Created by");?></th>
                                            <th><?php echo getTranslation("courselist:choose:start", "Start Dates");?></th>
                                            <th></th>
                                            <?php if ($isLecturer) { ?>
                                            <th></th>
                                            <th></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody data-link="row" class="rowlink">
                                        <?php
                                        $index = 0;
                                        for ($cntr = 0; $cntr < count($courses); $cntr++) {

                                            $initCntr = $cntr;
                                            $lang_array = array($courses[$cntr]["lang"]);
                                            $name_array = array($courses[$cntr]["name"]);

                                            $displayed_course_flag = false;

                                            while ($cntr < count($courses)-1) {
                                                if ($courses[$cntr]["id"] == $courses[$cntr + 1]["id"]) {
                                                    if($_SESSION["lang"]== $courses[$cntr]["lang"]){
                                                        $displayed_course_flag = true;
                                                        $temp_name = $courses[$cntr]["name"];
                                                        $temp_lang = $courses[$cntr]["lang"];
                                                        $temp_description = $courses[$cntr]["description"];
                                                    }
                                                    array_push($lang_array, $courses[$cntr + 1]["lang"]);
                                                    array_push($name_array, $courses[$cntr + 1]["name"]);
                                                    $cntr++;
                                                } else {
                                                    break;
                                                }
                                            }
                                // Add line brake after each date for more readability in the table
                                            $course_dates_array = explode("\n", $courses[$initCntr]["date_created"]);
                                            $index++;

                                            $current_course_id = $courses[$initCntr]["id"];
                                            $current_course_url = $courses[$initCntr]["space_url"];
                                            $current_course_credits = 0;
                                            for ($cntc = 0; $cntc < count($course_credits); $cntc++) {
                                                if($course_credits[$cntc]["course_id"]==$current_course_id)
                                                    $current_course_credits = $course_credits[$cntc]["credits"];
                                            }
                                            

                                            if($displayed_course_flag){
                                                $current_course_name = $temp_name;
                                                $current_course_lang = $temp_lang;
                                                $current_course_description = $temp_description;
                                            }else{
                                                $current_course_name = $courses[$cntr]["name"];
                                                $current_course_lang = $courses[$cntr]["lang"];
                                                $current_course_description= $courses[$cntr]["description"];
                                            }

                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="course.php?id=<?php echo $current_course_id . "&lang=" . $current_course_lang; ?>"><?php echo $current_course_name; ?></a>

                                                    <?php $i=0; foreach ($name_array as $c_name) { ?>
                                                    <p class="hidden"><?php echo $c_name; ?></p>
                                                    <?php $i++; } ?>
                                                </td>
                                                <td><?php echo $courses[$initCntr]["orga"]; ?></td>
                                                <td>
                                                    <?php 
                                                        $hasUnitStartDate = false;
                                                        $current_start = 0;
                                                        foreach ($course_start_date as $unit) {
                                                            if($unit['course_id']==$current_course_id){
                                                                echo $unit['start'] . "<br>";
                                                                $current_start = $unit['start'];
                                                                $hasUnitStartDate=true;
                                                            }
                                                        }
                                                        if(!$hasUnitStartDate){
                                                            foreach ($course_dates_array as $start_date) {
                                                                echo $start_date . "<br>";
                                                            } 
                                                        }
                                                    ?>    
                                                </td>
                                                <td class="language-flag-rows">
                                                    <?php $i=0; foreach ($lang_array as $c_lang) {
                                                        ?>
                                                        <input hidden value=<?php echo $c_lang; ?>>
                                                        <a href="course.php?id=<?php echo $current_course_id . "&lang=" . $c_lang ?>">
                                                            <img class="language-flag-element language-flag-onhover <?php if($i==0){?>language-flag-active<?php } ?>"
                                                            src="<?php echo "../images/flags/s_" . $c_lang . ".png" ?>">
                                                        </a>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </td>
                                                <?php if ($isLecturer) { ?>
                                                <td class="rowlink-skip">
                                                    <?php
                                                    $languages_count = 5;
                                                    $languages = array(
                                                        "en" => "English",
                                                        "de" => "Deutsch",
                                                        "es" => "Español",
                                                        "it" => "Italiano",
                                                        "gr" => "ελληνικά"
                                                        );
                                        //uncomment the line below to set the languages count to the number of available languages
                                        //$languages_count = $db->query("SELECT COUNT(*)as alLanguages FROM languages ")->fetchObject();
                                                        if (count($lang_array) == $languages_count){ ?>
                                                        <a href="#" disabled class="btn btn-translate btn-sm btn-danger btn-block"><?php echo getTranslation("courselist:admin:translate", "Translate to");?></a>
                                                        <?php }else{ ?>
                                                        <div class="dropdown btn-block">
                                                            <button class="btn btn-danger btn-sm dropdown-toggle btn-block" type="button" id="translate-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <?php echo getTranslation("courselist:admin:translate", "Translate to");?>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="translate-dropdown">
                                                                <?php
                                                                foreach($languages as $code => $language) {
                                                                  if (!in_array($code, $lang_array)) {
                                                                    echo "<a class='dropdown-item' href='editcourse.php?id=$current_course_id&lang=$code'>$language</a>";
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if (count($lang_array) > 1): ?>
                                                        <div class="dropdown btn-block">
                                                            <button class="btn btn-success btn-sm dropdown-toggle btn-block" type="button" id="edit-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <?php echo getTranslation("courselist:admin:edit", "Edit");?>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="edit-dropdown">
                                                                <?php
                                                                foreach($lang_array as $c_lang) {
                                                                    echo "<a class='dropdown-item' href='editcourse.php?id=$current_course_id&lang=$c_lang'>$c_lang</a>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <a href="editcourse.php?id=<?php echo $current_course_id; ?>&lang=<?php echo $current_course_lang; ?>" class="btn btn-edit btn-sm btn-success btn-block"><?php echo getTranslation("courselist:admin:edit", "Edit");?></a>
                                                    <?php endif; ?>
                                                    
                                                <input type="button"
                                                    data-id="<?php echo $current_course_id; ?>"
                                                    data-lang="<?php echo $current_course_lang; ?>"
                                                    class="btn btn-delete btn-sm btn-warning btn-block"
                                                    value="<?php echo getTranslation("courselist:admin:delete", "Delete");?>"></td>
                                                    <td class="rowlink-skip">
                                                    <?php
                                                        if($hasUnitStartDate && time() >= strtotime($current_start) || !$hasUnitStartDate){
                                                    ?>
                                                    <a href="../php/role_redirect.php?space=<?php echo $current_course_url; ?>" target="_blank" class="margin-left btn btn-sm btn-warning ">
                                                        <?php echo getTranslation("course:content:enterroom", "Enter Course Room");?>
                                                    </a>
                                                    <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <!-- Collapse div for course description -->
                                                    <td colspan="8">
                                                        <button type="button" class="btn btn-info" data-toggle="collapse"
                                                        data-target="#description-<?php echo $index; ?>"><?php echo getTranslation("courselist:choose:description", "Description");?>
                                                    </button>
                                                    <div id="description-<?php echo $index; ?>" class="collapse">
                                                        <?php echo $current_course_description; ?><br><br>
                                                        <?php echo getTranslation("courselist:choose:credits", "Credits").": ".$current_course_credits; ?>
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
        <script src="../js/filter-courses.js"></script>
    </body>
    </html>
