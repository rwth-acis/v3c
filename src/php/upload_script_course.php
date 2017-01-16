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

//in case of course translation
if (isset($_GET['id'])) {
    //Get the units for the course to be translated
    $course_units = $conn->query("SELECT * 
                            FROM course_to_unit 
                            JOIN course_units 
                            ON course_to_unit.unit_id = course_units.id
                            AND course_to_unit.unit_lang = course_units.lang
                            WHERE course_id = $id
                            AND course_lang ='en'")->fetchAll();

    //create course units for the translated courses
    foreach($course_units as $course_unit){

        $utitle = "ADD TRANSLATION FOR : " . $course_unit['title'];
        $udescription = "ADD TRANSLATION FOR : " . $course_unit['description'];

        $units_stmt = $conn->prepare("INSERT INTO course_units (id,lang,title, description, start_date, points) 
                             VALUES (:uid,:ulanguage,:utitle,:udescription,:ustart_date,:upoints)");
        $units_stmt->bindParam(":uid", $course_unit['id'], PDO::PARAM_INT);
        $units_stmt->bindParam(":ulanguage", $language, PDO::PARAM_STR);
        $units_stmt->bindParam(":utitle", $utitle, PDO::PARAM_STR);
        $units_stmt->bindParam(":udescription", $udescription, PDO::PARAM_STR);
        $units_stmt->bindParam(":ustart_date", $course_unit['start_date'], PDO::PARAM_STR);
        $units_stmt->bindParam(":upoints", $course_unit['points'], PDO::PARAM_INT);

        $success = $units_stmt->execute();

        //assign the copied course units to the translated course
        $c2u_stmt = $conn->prepare("INSERT INTO course_to_unit (course_id,course_lang,unit_id, unit_lang) 
                             VALUES (:cid,:ulanguage,:uid,:ulanguage)");

        $c2u_stmt->bindParam(":cid", $id, PDO::PARAM_INT);
        $c2u_stmt->bindParam(":ulanguage", $language, PDO::PARAM_STR);
        $c2u_stmt->bindParam(":uid", $course_unit['id'], PDO::PARAM_INT);

        $success = $c2u_stmt->execute();
    }
}


// After creating a course, the user is redirected to the edit page. The reason
// for this is, that it is not possible to add models on addcourse.php. But the user
// can add models on editcourse.php
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
?>
