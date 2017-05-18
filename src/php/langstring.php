<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

session_start();
include("localization.php");

$key = filter_input(INPUT_GET, 'key');
$default = filter_input(INPUT_GET, 'default');

echo getTranslation($key, $default);
?>
