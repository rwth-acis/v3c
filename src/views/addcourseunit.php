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
        </div>
    </div>
</header>

<?php
// TODO: Check whether page was called manually for a course that already has 5 units

// Check whether the currently logged in user is allowed to create courses
require '../php/access_control.php';
$accessControl = new AccessControl();
$course_id = filter_input(INPUT_GET, 'courseid');

$canCreateCourse = $accessControl->canUpdateCourse($course_id);
//FIXME DEBUG
$canCreateCourse = true;

if ($canCreateCourse) {
    include 'addcourseunit_content.php';
} else {
    include 'not_authorized.php';
}

include("footer.php");
?>

</body>

</html>
