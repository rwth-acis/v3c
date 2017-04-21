<!DOCTYPE html>
<html>
<head>

    <title>Delete course unit</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
    <?php

    include '../php/tools.php';

    $unit_id = filter_input(INPUT_GET, 'unit_id');
    $course_id = filter_input(INPUT_GET, 'course_id');
    $course_lang = filter_input(INPUT_GET, 'course_lang');

?>

<!-- Top level navigation and logo -->
<?php include("menu.php"); ?>

<!-- Banner with page headline -->
<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
         <h1><?php echo getTranslation("courseunitdel:head:name_tmp", "Delete course unit");
             ?></h1>
         </div>
     </div>
 </header>

 <?php
// Check whether the currently logged in user is allowed to delete courses
 require '../php/access_control.php';

 $accessControl = new AccessControl();
 $canDeleteCourse = $accessControl->canDeleteCourse($course_id);

 if ($canDeleteCourse) {
    ?>
    <!-- Confirmation check UI elements to ask user whether or not to delete the selected course -->
    <div class="center-block container">
        <div class="featured-box container delete-confirm-div">
            <p><strong><?php
                echo getTranslation("courseunitdel:head:confirm_tmp1", "Do you really want to delete the course unit?"); ?></strong></p>
                <a href="../php/delete_courseunit.php?course_id=<?php echo $course_id ?>&course_lang=<?php echo $course_lang ?>&unit_id=<?php echo $unit_id ?>" id="btn-yes" class="btn btn-warning col-sm-5 btn-yes-no"><?php echo getTranslation('general:button:yes', 'Yes');?></a>
                <a href="editcourse.php?id=<?php echo $course_id ?>&lang=<?php echo $course_lang ?>" id="btn-no" class="btn btn-success col-sm-5 btn-yes-no"><?php echo getTranslation('general:button:no', 'No');?></a>
            </div>
        </div>
        <?php
    } else {
        include 'not_authorized.php';
    }

    include("footer.php");
    ?>

</body>

</html>
