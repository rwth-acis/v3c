<?php
/**
 * Created by PhpStorm.
 * User: Tilman
 * Date: 25.01.2017
 * Time: 20:55
 */
//Establish database connection
$db = require_once 'db_connect.php';

//filter data from POST
$role = filter_input(INPUT_POST, 'role', FILTER_VALIDATE_INT);
$orga = filter_input(INPUT_POST, 'orga');
$sub = filter_input(INPUT_POST, 'sub');

//update database entry
$sql = "UPDATE users SET role = :role, affiliation = :orga WHERE openIdConnectSub = :sub";
$statement = $db->prepare($sql);
$statement->bindParam(":role", $role, PDO::PARAM_INT);
if ($orga !== 'NULL') {
  $statement->bindParam(":orga", $orga, PDO::PARAM_INT);
}
else {
	if($role!='3'){
		header('Location:../views/manage_users.php?Update=false');
	}else{
		$statement->bindValue(':orga', null, PDO::PARAM_INT);
	}
}
$statement->bindParam(":sub", $sub, PDO::PARAM_STR);

$success = $statement->execute();

if (!$success) {
    print_r($statement->errorInfo());
    $user_update_notice = $statement->errorInfo();
    die($user_update_notice);
} else {
    $user_update_notice = "User successfully updated!";
}

echo $user_update_notice;


//Return to User management page
header('Location:../views/manage_users.php?Update=true');
