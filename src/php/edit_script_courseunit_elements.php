<?php

// Create database connection
$conn = require '../php/db_connect.php';


//Get input data from form
$course_id = filter_input(INPUT_GET, 'courseid', FILTER_VALIDATE_INT);
$unit_id = filter_input(INPUT_GET, 'unitid', FILTER_VALIDATE_INT);
$unit_lang = filter_input(INPUT_GET, 'unitlang');
$store = isset($_GET['store']);

if ($store) {
  $inputJSON = file_get_contents('php://input');
  $input = json_decode($inputJSON, TRUE);

  echo $inputJSON;
}
else {
  echo "[]"; // TODO remove
}


// TODO get from db

/*
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
}*/




?>
