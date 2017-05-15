<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$conn = require '../php/db_connect.php';
require '../php/role_database_sync.php';
$role = new RoleSync();

//Get input data from form
$unit_id = filter_input(INPUT_GET, 'unit_id');
$course_id = filter_input(INPUT_GET, 'course_id');
$course_lang = filter_input(INPUT_GET, 'course_lang');

// TODO: Check whether user is creator of this course, only the creator can delete the unit

// destroy activity
$role->destroyUnitActivity($unit_id);

// delete from db
$stmt = $conn->prepare("DELETE FROM course_units WHERE course_units.id = :unit_id");
$stmt->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
$success = $stmt->execute();
if (!$success) {
    die("ERROR");
}

header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
