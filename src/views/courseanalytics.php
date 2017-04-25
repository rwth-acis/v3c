<?php
$course_id = filter_input(INPUT_GET, 'id');
$course_lang = filter_input(INPUT_GET, 'lang');
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv='X-UA-Compatible' content='IE=edge' charset='utf8'/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Course Analytics</title>


</head>

<body>
  <?php include "menu.php"; ?>

  <header id='head' class='secondary'>
    <div class='container'>
      <div class='row'>
        <h1><?php echo getTranslation("courseanalytics:head:title", "Course Analytics");?></h1>
        <a href="course.php?id=<?php echo $_GET['id'] ?>&lang=<?php echo $_GET['lang'] ?>" class="tagline"><?php echo getTranslation("general:header:back", "Back");?></a>
    </div>
</div>
</header>
<?php
// Check whether the currently logged in user is allowed to edit courses
require '../php/access_control.php';


$accessControl = new AccessControl();

$canEditCourse = $accessControl->canUpdateCourse($course_id);

if ($canEditCourse) {
    include 'courseanalytics_content.php';
} else {
    include 'not_authorized.php';
}


include("footer.php");
?>

</body>
</html>
