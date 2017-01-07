<?php

/**
 * Copyright 2015 Adam Brunnmeier, Dominik Studer, Alexandra Wörner, Frederik Zwilling, Ali Demiralp, Dev Sharma, Luca Liehner, Marco Dung, Georgios Toubekis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @file upload_script_course.php
 *
 * Adss new course to the course database on the server
 * adds metadata about it database.
 */
session_start();

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';
require_once '../php/tools.php';

//Get input data from form
$name = filter_input(INPUT_POST, 'name');
$profession = filter_input(INPUT_POST, 'profession');
$domain = filter_input(INPUT_POST, 'domain');
$description = filter_input(INPUT_POST, 'description');

// Get the ID (of our DB) of the currently logged in user. Required, because this 
// user will be registered as the creator of the course.
//ob_start();
//$user_database_entry = getSingleDatabaseEntryByValue('users', 'openIdConnectSub', $_SESSION['sub']);
//ob_end_clean();

// TODO: Add organization (creator) to form
$creator = 'kpapavramidis@mastgroup.gr';  // EUROTraining

// Create database-entry
// TODO: Get lang from form
$statement = $conn->prepare("INSERT INTO courses (lang, name, description, domain, profession, creator) 
                             VALUES ('en', :name, :description, :domain, :profession, :creator)");
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

// TODO: Get lang from form
$course_id = $conn->lastInsertId();
$course_lang = "en";


// After creating a course, the user is redirected to the edit page. The reason
// for this is, that it is not possible to add models on addcourse.php. But the user
// can add models on editcourse.php
header("Location: ../views/editcourse.php?id=$course_id&lang=$course_lang");
?>
