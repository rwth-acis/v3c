<?php

// TODO: DELETION DOES NOT WORK YET

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';

//Get input data from form
$course_id = filter_input(INPUT_POST, 'course_id');
$course_lang = filter_input(INPUT_POST, 'course_lang');

// Get all models associated with the course
$sql = "DELETE FROM courses WHERE courses.id = :course_id AND courses.lang = :course_lang";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

// TODO: Check whether user is creator of this course, only the creator can delete the course
$success = $stmt->execute();
if ($success) {
    die("<p>Course successfully deleted.</p>");  // FIXME: die() does not prevent redirect
} else {
    die("<p class='error'>Could not delete course.</p>");
}
