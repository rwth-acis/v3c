<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = require '../php/db_connect.php';

$id = filter_input(INPUT_GET, 'id');

$stmt = $conn->prepare("SELECT *
                        FROM widget_instances_slides
                        WHERE id = :id
                        LIMIT 1");

$stmt->bindParam(":id", $id, PDO::PARAM_INT);

if ($stmt->execute() !== FALSE) {
    $res = $stmt->fetch();
    echo '{"id": '. $res['id'] .', "name": "'. $res['name'] .'", "url": "'. $res['url'] .'"}';
}
else {
  http_response_code(404);
  echo "Not found";
}

?>
