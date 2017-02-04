<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | V3C</title>

    <link rel='stylesheet' type='text/css' href='../css/style.css'>
</head>

<body>
<?php

include("menu.php");


// FIXME: debug

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

//unset($_SESSION);


// Get all entries from the user table in the database

include '../php/db_connect.php';
include '../php/tools.php';
include '../php/access_control.php';

$accessControl = new AccessControl();
$isAdmin = true;
//$isAdmin = $accessControl->isAdmin();
if ($isAdmin) {
    include 'manage_users_content.php';
} else {
    include 'not_authorized.php';
}


include("footer.php"); ?>

</body>
</html>
