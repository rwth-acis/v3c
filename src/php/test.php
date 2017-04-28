<?php
require_once 'tools.php';
require_once 'role_api.php';
$token = getAdminToken();
$api = new RoleAPI("http://virtus-vet.eu:8081/", $token);
$result = $api->createSpace("deinemama");

echo "TOKEN ".$token;
echo "RESULT ".$result;
?>
