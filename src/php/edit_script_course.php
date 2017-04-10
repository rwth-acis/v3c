<?php

// Create database connection
$conn = require '../php/db_connect.php';


//Get input data from form
$course_id = filter_input(INPUT_POST, 'courseid', FILTER_VALIDATE_INT);
$course_lang = filter_input(INPUT_POST, 'courselang');

$name = filter_input(INPUT_POST, 'name');
$profession = filter_input(INPUT_POST, 'profession');
$domain = filter_input(INPUT_POST, 'domain');
$description = filter_input(INPUT_POST, 'description');

// Create database-entry
$statement = $conn->prepare("UPDATE courses
  SET  domain = :domain
  WHERE courses.id = :course_id");

$statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$statement->bindParam(":domain", $domain, PDO::PARAM_STR);

$success = $statement->execute();
if (!$success) {
  print_r($statement->errorInfo());
  die("Error saving course.");
}

$statement = $conn->prepare("REPLACE INTO courses_lng
  SET name = :name,
  description = :description,
  profession = :profession,
  course_id = :course_id,
  lang = :course_lang");

$statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$statement->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":profession", $profession, PDO::PARAM_STR);

$success = $statement->execute();
if (!$success) {
  print_r($statement->errorInfo());
  die("Error saving course.");
}


// Return back to the edit page, now reflecting the changes
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");

?>
