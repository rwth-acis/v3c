<?php

// Create database connection
$conn = require '../php/db_connect.php';


//Get input data from form
$course_id = filter_input(INPUT_POST, 'courseid', FILTER_VALIDATE_INT);
$unit_id = filter_input(INPUT_POST, 'unitid', FILTER_VALIDATE_INT);
$unit_lang = filter_input(INPUT_POST, 'unitlang');


$title = filter_input(INPUT_POST, 'title');
$points = filter_input(INPUT_POST, 'points');
$startdate = filter_input(INPUT_POST, 'startdate');
$description = filter_input(INPUT_POST, 'description');

// Update database-entry
$statement = $conn->prepare("UPDATE course_units 
                              SET title = :title, 
                                points = :points, 
                                start_date = :startdate, 
                                description = :description
                             WHERE id = :unit_id
                              AND lang = :unit_lang");

$statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
$statement->bindParam(":unit_lang", $unit_lang, PDO::PARAM_STR);
$statement->bindParam(":title", $title, PDO::PARAM_STR);
$statement->bindParam(":points", $points, PDO::PARAM_INT);
$statement->bindParam(":startdate", $startdate, PDO::PARAM_STR);
$statement->bindParam(":description", $description, PDO::PARAM_STR);

$success = $statement->execute();
if (!$success) {
    print_r($statement->errorInfo());
    die("Error saving course.");
}


// Return back to the edit page, now reflecting the changes
header("Location: ../views/editcourse.php?id=$course_id&lang=$unit_lang");

?>