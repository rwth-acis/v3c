<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';
require_once '../php/tools.php';
require_once '../php/role_api.php';

//Get input data from form
$name = filter_input(INPUT_POST, 'name');
$language = filter_input(INPUT_POST, 'language');
$profession = filter_input(INPUT_POST, 'profession');
$domain = filter_input(INPUT_POST, 'domain');
$description = filter_input(INPUT_POST, 'description');

// get affiliation from current user
$creator = getSingleDatabaseEntryByValue('organizations', 'id', $_SESSION['affiliation']);

// Create database-entry
$statement = $conn->prepare("INSERT INTO courses (domain, creator, default_lang)
	VALUES (:domain, :creator, :default_lang)");
$statement->bindParam(":default_lang", $language, PDO::PARAM_STR);
$statement->bindParam(":domain", $domain, PDO::PARAM_STR);
$statement->bindParam(":creator", $creator['email'], PDO::PARAM_STR);

$success = $statement->execute();
if (!$success) {
	print_r($statement->errorInfo());
	die("Error saving course.");
}


$course_id = $conn->lastInsertId();
$course_lang = $language;


// create role space
$api = new RoleAPI("http://virtus-vet.eu:8081/", $_SESSION['access_token']);
$api->createSpace($course_id.strtolower(urlencode(str_replace(' ', '',$name))));
$role_url = $course_id.strtolower(urlencode(str_replace(' ', '',$name)));

$statement = $conn->prepare("UPDATE courses SET space_url= :role_url 
	WHERE id=:id");
$statement->bindParam(":role_url", $role_url, PDO::PARAM_STR);
$statement->bindParam(":id", $course_id, PDO::PARAM_INT);
$success = $statement->execute();
if (!$success) {
	print_r($statement->errorInfo());
	die("Error updating role url.");
}


$statement = $conn->prepare("INSERT INTO courses_lng (course_id, lang, name, description, profession)
	VALUES (:id, :language, :name, :description, :profession)");
$statement->bindParam(":id", $course_id, PDO::PARAM_INT);
$statement->bindParam(":language", $language, PDO::PARAM_STR);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":profession", $profession, PDO::PARAM_STR);

$success = $statement->execute();


if (!$success) {

	print_r($statement->errorInfo());
	die("Error saving course.");
}

// After creating a course, the user is redirected to the edit page. The reason
// for this is, that it is not possible to add models on addcourse.php. But the user
// can add models on editcourse.php
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
?>
