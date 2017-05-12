<!DOCTYPE html>
<html>
<head>
    <title>Create a New Course Unit</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php include("menu.php"); ?>

<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php echo getTranslation("addcourseunit:add:create", "Create a new course unit");?></h1>
            <a href="editcourse.php?id=<?php echo $_GET['courseid'] ?>&lang=<?php echo $_GET['lang'] ?>" class="tagline"><?php echo getTranslation("general:header:back", "Back");?></a>
        </div>
    </div>
</header>

<?php

// Check whether the currently logged in user is allowed to create courses
require_once '../php/access_control.php';
$accessControl = new AccessControl();
$course_id = filter_input(INPUT_GET, 'courseid', FILTER_VALIDATE_INT);
$course_lang = filter_input(INPUT_GET, 'lang');

$canCreateCourse = $accessControl->canUpdateCourse($course_id);

if ($canCreateCourse) {
    include 'addcourseunit_content.php';
} else {
    include 'not_authorized.php';
}

include("footer.php");
?>

</body>

</html>
