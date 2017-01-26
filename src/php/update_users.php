<?php
/**
 * Created by PhpStorm.
 * User: Tilman
 * Date: 25.01.2017
 * Time: 20:55
 */
//Establish database connection
$db = require 'db_connect.php';

//get data from POST
$role = filter_input(INPUT_POST, 'role');
$sub = filter_input(INPUT_POST, 'sub');

//update database entry
$sql = "UPDATE users SET role = :role WHERE openIdConnectSub = :sub";
$statement = $db->prepare($sql);
$statement->bindParam(":role", $role, PDO::PARAM_INT);
$statement->bindParam(":sub", $sub, PDO::PARAM_STR);
$success = $statement->execute();
if (!$success) {
    print_r($statement->errorInfo());
    $user_update_notice = $statement->errorInfo();
    die("Error updating user.");
} else {
    $user_update_notice = "User successfully updated!";
}


//Return to User management page
header('Location:../views/manage_users.php?Update=true');

