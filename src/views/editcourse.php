<?php
$conn = require_once '../php/db_connect.php';
$course_id = filter_input(INPUT_GET, 'id');
$course_lang = "en";  // default value
if (isset($_GET["lang"])) {
    $course_lang = filter_input(INPUT_GET, "lang");
}
// Get course info
$stmt = $conn->prepare("SELECT courses.*, courses_lng.*
  FROM courses, courses_lng
  WHERE courses.id = :course_id
  AND courses_lng.course_id = courses.id
  AND (courses_lng.lang = :course_lang OR courses_lng.lang = (SELECT default_lang FROM courses WHERE id = :course_id))");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
if (!$success) {
    echo "Error loading course.";
} else {
    $course = $stmt->fetchAll();
    if (sizeof($course) == 1 || $course[0]['lang'] == $course_lang) {
      $course = $course[0];
  }
  else {
      $course = $course[1];
  }
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
        <h1><?php echo getTranslation("editcourse:head:edit", "Edit Your Course");?> "<?php echo htmlentities($course['name']); ?>"</h1>
        <a href="editcourse.php?id=<?php echo $_GET['id'] ?>&lang=<?php echo $_GET['lang'] ?>" class="tagline"><?php echo getTranslation("general:header:back", "Back");?></a>        
    </div>
</div>
</header>
<?php
// Check whether the currently logged in user is allowed to edit courses
require '../php/access_control.php';


$accessControl = new AccessControl();

$canEditCourse = $accessControl->canUpdateCourse($course_id);

if ($canEditCourse) {
    include 'editcourse_content.php';
} else {
    include 'not_authorized.php';
}


include("footer.php");
?>

</body>
</html>
