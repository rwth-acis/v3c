<?php

$conn = require "../php/db_connect.php";
$course_id = filter_input(INPUT_GET, 'cid');
$unit_id = filter_input(INPUT_GET, 'uid', FILTER_VALIDATE_INT);
$course_lang = filter_input(INPUT_GET, 'ulang');

// Get course info
$statement = $conn->prepare("SELECT *, CASE WHEN (SELECT lang FROM course_units_lng WHERE lang = :unit_lang AND unit_id = :unit_id) IS NULL THEN 'False' ELSE 'True' END AS translated
    FROM course_units, course_units_lng
    WHERE course_units.id = :unit_id
    AND course_units.id = course_units_lng.unit_id
    AND course_units_lng.lang = (SELECT
    IFNULL( (SELECT lang FROM course_units_lng WHERE lang = :unit_lang AND unit_id = :unit_id),
    course_units.default_lang ))
    LIMIT 1");

$statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
$statement->bindParam(":unit_lang", $unit_lang, PDO::PARAM_STR);

$success = $statement->execute();
if ($success) {
    $course_unit = $statement->fetch();
}
else {
  print_r($statement->errorInfo());
  die("error");
}
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
        <h1><?php echo getTranslation("editcourse:head:edit", "Edit Your Course");?> "<?php echo htmlentities($course_unit['title']); ?>"</h1>
        <a href="editcourse.php?id=<?php echo $_GET['cid'] ?>&lang=<?php echo $_GET['ulang'] ?>" class="tagline"><?php echo getTranslation("general:header:back", "Back");?></a> 
    </div>
</div>
</header>
<?php
// Check whether the currently logged in user is allowed to edit courses
require_once '../php/access_control.php';

$accessControl = new AccessControl();

$canEditCourse = $accessControl->canUpdateCourse($course_id);

if ($canEditCourse) {
    include 'editcourseunit_content.php';
} else {
    include 'not_authorized.php';
}


include("footer.php");
?>

</body>
</html>
