<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';
require_once '../php/tools.php';

//Get course id in case of course translatation
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}


//Get input data from form
$name = filter_input(INPUT_POST, 'name');
$language = filter_input(INPUT_POST, 'language');
$profession = filter_input(INPUT_POST, 'profession');
$domain = filter_input(INPUT_POST, 'domain');
$description = filter_input(INPUT_POST, 'description');

// TODO: Add organization (creator) to form
$creator = 'kpapavramidis@mastgroup.gr';  // EUROTraining

// Create database-entry
$statement = $conn->prepare("INSERT INTO courses (id,lang, name, description, domain, profession, creator) 
                             VALUES (:id,:language, :name, :description, :domain, :profession, :creator)");
$statement->bindParam(":id", $id, PDO::PARAM_INT);
$statement->bindParam(":language", $language, PDO::PARAM_STR);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":domain", $domain, PDO::PARAM_STR);
$statement->bindParam(":profession", $profession, PDO::PARAM_STR);
$statement->bindParam(":creator", $creator, PDO::PARAM_INT);

$success = $statement->execute();
if (!$success) {
    print_r($statement->errorInfo());
    die("Error saving course.");
}

$course_id = $conn->lastInsertId();
$course_lang = $language;


// After creating a course, the user is redirected to the edit page. The reason
// for this is, that it is not possible to add models on addcourse.php. But the user
// can add models on editcourse.php
//header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
?>
