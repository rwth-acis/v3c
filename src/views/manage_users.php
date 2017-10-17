<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | V3C</title>

    <link rel='stylesheet' type='text/css' href='../css/style.css'>
    <style>
        .hidden{
            visibility: hidden;
        }

        i{
            border: solid black;
            border-width: 0 3px 3px 0;
            display: inline-block;
            padding: 3px;
            margin-left: 5px;
        }
    	.up {
		    transform: rotate(-135deg);
		    -webkit-transform: rotate(-135deg);
		}

		.down {
		    transform: rotate(45deg);
		    -webkit-transform: rotate(45deg);
		}
    </style>
</head>

<body>
<?php

include("menu.php");

// Get all entries from the user table in the database

include '../php/db_connect.php';
require_once '../php/tools.php';
require_once '../php/access_control.php';

$accessControl = new AccessControl();
$isAdmin = $accessControl->isAdmin();

if ($isAdmin) {
    include 'manage_users_content.php';
} else {
    include 'not_authorized.php';
}


include("footer.php"); ?>

</body>
</html>
