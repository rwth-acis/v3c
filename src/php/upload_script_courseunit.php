<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = require '../php/db_connect.php';

// Get input data from form
$course_id = filter_input(INPUT_GET, "course_id", FILTER_VALIDATE_INT);
$course_lang = filter_input(INPUT_GET, "course_lang");
$name = filter_input(INPUT_POST, 'name');
$points = filter_input(INPUT_POST, 'points');
$startdate = filter_input(INPUT_POST, 'startdate');
$description = filter_input(INPUT_POST, 'description');

// Create database-entry
$stmt = $conn->prepare("INSERT INTO course_units (title, lang, points, start_date, description)
                             VALUES (:name, :lang, :points, :startdate, :description)");
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":lang", $course_lang, PDO::PARAM_STR);  // course unit inherits course language
$stmt->bindParam(":points", $points, PDO::PARAM_INT);
$stmt->bindParam(":startdate", $startdate, PDO::PARAM_STR);
$stmt->bindParam(":description", $description, PDO::PARAM_STR);

$success = $stmt->execute();
if (!$success) {
    print_r($stmt->errorInfo());
    die("Error saving course unit.");
}

$course_unit_id = $conn->lastInsertId();

$stmt2 = $conn->prepare("INSERT INTO course_to_unit (course_id, unit_id) VALUES (:course_id, :cu_id)");
$stmt2->bindParam(":course_id", $course_id);
$stmt2->bindParam(":cu_id", $course_unit_id);

$success = $stmt2->execute();
if (!$success) {
    print_r($stmt2->errorInfo());
    die("Error connecting course unit to course.");
}

// add unit for other course languages
$statement = $conn->prepare("SELECT lang FROM courses WHERE id = :course_id AND lang <> :course_lang");
$statement->bindParam(":course_id",$course_id,PDO::PARAM_INT);
$statement->bindParam(":course_lang",$course_lang,PDO::PARAM_STR);
if (!$statement->execute()) {
  print_r($statement->errorInfo());
  die("Error.");
}
$langs = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($langs as $l) {
  $stmt = $conn->prepare("INSERT INTO course_units (id, title, lang, points, start_date, description)
                               VALUES (:id, :name, :lang, :points, :startdate, :description)");
  $stmt->bindValue(":name", "ADD TRANSLATION FOR : " . $name, PDO::PARAM_STR);
  $stmt->bindParam(":id", $course_unit_id, PDO::PARAM_INT);
  $stmt->bindValue(":lang", $l['lang'], PDO::PARAM_STR);
  $stmt->bindParam(":points", $points, PDO::PARAM_INT);
  $stmt->bindParam(":startdate", $startdate, PDO::PARAM_STR);
  $stmt->bindValue(":description", "ADD TRANSLATION FOR : " . $description, PDO::PARAM_STR);
  if (!$stmt->execute()) {
    print_r($stmt->errorInfo());
    die("Error.");
  }
}


// After creating a course, the user is redirected to the edit page. The reason
// for this is, that it is not possible to add models on addcourse.php. But the user
// can add models on editcourse.php
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
?>
