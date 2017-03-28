<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';
require_once '../php/tools.php';

//Get course id in case of course translatation

$id = filter_input(INPUT_GET, 'tid');
$lang = filter_input(INPUT_GET, 'tlang');

//Get input data from form
$name = filter_input(INPUT_POST, 'name');
$language = filter_input(INPUT_POST, 'language');
$profession = filter_input(INPUT_POST, 'profession');
$domain = filter_input(INPUT_POST, 'domain');
$description = filter_input(INPUT_POST, 'description');

// get affiliation from current user
//$creator = $_SESSION['affiliation'];
$creator = getSingleDatabaseEntryByValue('organizations', 'id', $_SESSION['affiliation']);
// $creator = 'kpapavramidis@mastgroup.gr';  // EUROTraining

// Create database-entry
$statement = $conn->prepare("INSERT INTO courses (id,lang, name, description, domain, profession, creator)
                             VALUES (:id,:language, :name, :description, :domain, :profession, :creator)");
$statement->bindParam(":id", $id, PDO::PARAM_INT);
$statement->bindParam(":language", $language, PDO::PARAM_STR);
$statement->bindParam(":name", $name, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);
$statement->bindParam(":domain", $domain, PDO::PARAM_STR);
$statement->bindParam(":profession", $profession, PDO::PARAM_STR);
$statement->bindParam(":creator", $creator['email'], PDO::PARAM_STR);

$success = $statement->execute();
if (!$success) {
    print_r($statement->errorInfo());
    die("Error saving course.");
}


$course_id = $conn->lastInsertId();
$course_lang = $language;

//in case of course translation
if (isset($_GET['tid'])) {
  // course units
    $stmt = $conn->prepare("INSERT INTO course_units (id,lang,title, description, start_date, points)
                         SELECT id, :ulanguage, CONCAT('TRANSLATE ', title), CONCAT('TRANSLATE ', description), start_date, points
                         FROM course_units, course_to_unit
                         WHERE course_to_unit.unit_id = course_units.id AND course_id = :tid AND course_units.lang = :tlang");
    $stmt->bindParam(":tid",$id,PDO::PARAM_INT);
    $stmt->bindParam(":tlang",$lang,PDO::PARAM_STR);
    $stmt->bindParam(":ulanguage", $language, PDO::PARAM_STR);
    if (!$stmt->execute()) {
        print_r($stmt->errorInfo());
        die("Error adding translations.");
    }

    // widget data slides
    $stmt = $conn->prepare("INSERT INTO widget_data_slides (element_id,lang,title,url)
                         SELECT widget_data_slides.element_id, :ulanguage, CONCAT('TRANSLATE ', title), url
                         FROM widget_data_slides, course_to_unit, unit_to_element
                         WHERE course_to_unit.course_id = :tid
                          AND course_to_unit.unit_id = unit_to_element.unit_id
                          AND unit_to_element.element_id = widget_data_slides.element_id
                          AND widget_data_slides.lang = :tlang");
    $stmt->bindParam(":tid",$id,PDO::PARAM_INT);
    $stmt->bindParam(":tlang",$lang,PDO::PARAM_STR);
    $stmt->bindParam(":ulanguage", $language, PDO::PARAM_STR);
    if (!$stmt->execute()) {
        print_r($stmt->errorInfo());
        die("Error adding translations.");
    }

    // widget data videos
    $stmt = $conn->prepare("INSERT INTO widget_data_video (element_id,lang,title,url)
                         SELECT widget_data_video.element_id, :ulanguage, CONCAT('TRANSLATE ', title), url
                         FROM widget_data_video, course_to_unit, unit_to_element
                         WHERE course_to_unit.course_id = :tid
                          AND course_to_unit.unit_id = unit_to_element.unit_id
                          AND unit_to_element.element_id = widget_data_video.element_id
                          AND widget_data_video.lang = :tlang");
    $stmt->bindParam(":tid",$id,PDO::PARAM_INT);
    $stmt->bindParam(":tlang",$lang,PDO::PARAM_STR);
    $stmt->bindParam(":ulanguage", $language, PDO::PARAM_STR);
    if (!$stmt->execute()) {
        print_r($stmt->errorInfo());
        die("Error adding translations.");
    }


    // TODO copy other entries as well ...
}


// After creating a course, the user is redirected to the edit page. The reason
// for this is, that it is not possible to add models on addcourse.php. But the user
// can add models on editcourse.php
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
?>
