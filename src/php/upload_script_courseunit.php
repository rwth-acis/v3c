<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../php/role_database_sync.php';
$conn = require '../php/db_connect.php';

$role = new RoleSync();

// Get input data from form
$course_id = filter_input(INPUT_GET, "course_id", FILTER_VALIDATE_INT);
$course_lang = filter_input(INPUT_GET, "course_lang");
$name = filter_input(INPUT_POST, 'name');
$points = filter_input(INPUT_POST, 'points');
$startdate = filter_input(INPUT_POST, 'startdate');
$description = filter_input(INPUT_POST, 'description');

// Create database-entry
$stmt = $conn->prepare("INSERT INTO course_units (points, start_date, default_lang, course_id)
                             VALUES (:points, :startdate, :lang, :course_id)");
$stmt->bindParam(":points", $points, PDO::PARAM_INT);
$stmt->bindParam(":startdate", $startdate, PDO::PARAM_STR);
$stmt->bindParam(":lang", $course_lang, PDO::PARAM_STR);
$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);

$success = $stmt->execute();
if (!$success) {
    print_r($stmt->errorInfo());
    die("Error saving course unit.");
}

$course_unit_id = $conn->lastInsertId();

// create lang specific entry
$stmt = $conn->prepare("INSERT INTO course_units_lng (unit_id, title, lang, description)
                             VALUES (:unit_id, :name, :lang, :description)");
$stmt->bindParam(":name", $name, PDO::PARAM_STR);
$stmt->bindParam(":lang", $course_lang, PDO::PARAM_STR);
$stmt->bindParam(":description", $description, PDO::PARAM_INT);
$stmt->bindParam(":unit_id", $course_unit_id, PDO::PARAM_STR);

$success = $stmt->execute();
if (!$success) {
    print_r($stmt->errorInfo());
    die("Error saving course unit.");
}

// role
$role->createUnitActivity($course_unit_id);

// After creating a course, the user is redirected to the edit page. The reason
// for this is, that it is not possible to add models on addcourse.php. But the user
// can add models on editcourse.php
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
?>
