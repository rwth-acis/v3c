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

  <link rel="stylesheet" href="../css/courseanalytics.css">

</head>

<body>
  <?php include "menu.php"; ?>
  <?php
    $conn = require_once '../php/db_connect.php';

    // Gets course details with it's creator information
    $stmt = $conn->prepare("SELECT courses.*, courses_lng.*, organizations.name AS orga, organizations.email AS orga_email
      FROM courses, organizations, courses_lng
      WHERE courses.id = :course_id
      AND courses.creator = organizations.email
      AND courses_lng.course_id = courses.id
      AND (courses_lng.lang = :course_lang OR courses_lng.lang = (SELECT default_lang FROM courses WHERE id = :course_id))
      ");

    $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    $stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

    $success = $stmt->execute();
    if (!$success) {
        echo "Error loading course.";
    } else {
      $course_details = $stmt->fetchAll();
      if (sizeof($course_details) == 1 || $course_details[0]['lang'] == $course_lang) {
        $course_details = $course_details[0];
      }
      else {
        $course_details = $course_details[1];
      }
    }

  ?>

  <header id='head' class='secondary'>
    <div class='container'>
      <div class='row'>
        <h3><?php echo getTranslation("courseanalytics:head:title", "Course Analytics");?> - <?php echo $course_details["name"]; ?></h3>
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
