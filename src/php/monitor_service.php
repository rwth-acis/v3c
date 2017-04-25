
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';

// get affiliation from current user
// $user = getSingleDatabaseEntryByValue('organizations', 'id', $_SESSION['affiliation']);
$user = 'me';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_GET, 'action');
    $value = filter_input(INPUT_GET, 'value');

    // Create database-entry
    $statement = $conn->prepare("INSERT INTO `user_actions` (`user`, `action`, `value`, `time`) VALUES (:user, :action, :value, CURRENT_TIMESTAMP)");
    $statement->bindParam(":user", $user, PDO::PARAM_STR);
    $statement->bindParam(":action", $action, PDO::PARAM_STR);
    $statement->bindParam(":value", $value, PDO::PARAM_STR);


    $success = $statement->execute();
    if (!$success) {
        print_r($statement->errorInfo());
        die("Error saving course.");
    }
} else {
    die('Unsupported request type!');
}

?>
