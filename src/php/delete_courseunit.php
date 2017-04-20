<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$conn = require '../php/db_connect.php';
require '../php/tools.php';
require '../php/role_api.php';

//Get input data from form
$unit_id = filter_input(INPUT_POST, 'unit_id');
$course_id = filter_input(INPUT_POST, 'course_id');
$course_lang = filter_input(INPUT_POST, 'course_lang');

// TODO: Check whether user is creator of this course, only the creator can delete the unit

// get activity url
$stmt = $conn->prepare("SELECT activity_url FROM course_units WHERE course_units.id = :$unit_id");
$stmt->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);

$success = $stmt->execute();
$activity_url = "";
if ($success) {
	$activity_url = $stmt->fetch()[0];
}

// delete from space
$api = new RoleAPI("http://virtus-vet.eu:8081/", getAdminToken());
$api->removeActivityFromSpace($activity_url);

// delete from db
$stmt = $conn->prepare("DELETE FROM course_units WHERE course_units.id = :$unit_id");
$stmt->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
$success = $stmt->execute();
if (!$success) {
    die("ERROR");
}

header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
