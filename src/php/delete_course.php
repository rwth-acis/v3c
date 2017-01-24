<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';

//Get input data from form
$course_id = filter_input(INPUT_POST, 'course_id');
$course_lang = filter_input(INPUT_POST, 'course_lang');

// Get subject of course to return this to JS (for correct redirect)
$stmt = $conn->prepare("SELECT courses.domain
                        FROM courses
                        WHERE courses.id = :course_id 
                            AND courses.lang = :course_lang 
                        LIMIT 1");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

$success = $stmt->execute();
$subject = "";
if ($success) {
    $subject = $stmt->fetch()[0];
}

// TODO: Instead of deleting courses, allow only to deactivate them (when do you really need to completely delete a course?)
$stmt = $conn->prepare("DELETE FROM courses 
                        WHERE courses.id = :course_id 
                          AND courses.lang = :course_lang");

$stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
$stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);

// TODO: Check whether user is creator of this course, only the creator can delete the course
$success = $stmt->execute();
if ($success) {
    echo $subject;  // echos get returned to JS
} else {
    echo "FALSE";
}
