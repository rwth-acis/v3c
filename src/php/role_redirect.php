<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once '../config/config.php';
require '../php/role_api.php';
if (isset($_GET["space"])) {
	$api = new RoleAPI("http://virtus-vet.eu:8081/", $_SESSION["access_token"]);
	if ($api->login()) {
		$api->login_cookie();
	}
	$api->joinSpace($_GET["space"]);
	$url = 'http://virtus-vet.eu:8081/spaces/'.$_GET["space"];
	if(isset($_GET["activity"])) $url .= '#activity='.$_GET["activity"];
    header('Location: ' . $url);
} else {
    header('Location: ' . $baseUrl . '/src/views/welcome.php');
}
