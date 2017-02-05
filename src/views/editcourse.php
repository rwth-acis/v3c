<?php

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' charset='utf8'/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Your Course</title>

    <!-- Additional styles -->
    <link rel="stylesheet" href="../css/editcourse.css">

</head>

<body>
<?php include "menu.php"; ?>

<header id='head' class='secondary'>
    <div class='container'>
        <div class='row'>
            <h1><?php echo getTranslation("editcourse:head:edit", "Edit Your Course");?></h1>
        </div>
    </div>
</header>
<?php
// Check whether the currently logged in user is allowed to edit courses
require '../php/access_control.php';

$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');

$accessControl = new AccessControl();

$canEditCourse = $accessControl->canUpdateCourse($course_id, $course_lang);

if ($canEditCourse) {
    include 'editcourse_content.php';
} else {
    include 'not_authorized.php';
}


include("footer.php");
?>

</body>
</html>
