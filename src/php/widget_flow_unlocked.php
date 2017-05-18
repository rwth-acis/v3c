<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = require '../php/db_connect.php';

// element id
$element_id = filter_input(INPUT_GET, 'element_id');

// user id
if (!isset($_SESSION['sub'])) {
  http_response_code(403);
  die("User not found");
}
$stmt = $conn->prepare("SELECT id FROM users WHERE openIdConnectSub = :sub");
$stmt->bindParam(":sub", $_SESSION['sub'], PDO::PARAM_STR);
if (!$stmt->execute()) {
  http_response_code(500);
  die("Error.");
}
$data = $stmt->fetch();
if (!is_array($data)) {
  http_response_code(403);
  die("User not found");
}
$user_id = $data["id"];

$stmt = $conn->prepare("SELECT COUNT(*) FROM user_actions WHERE user_id = :user_id AND value = :element_id AND action='unlockWidget'");
$stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
$stmt->bindValue(":element_id", $element_id, PDO::PARAM_STR);
if (!$stmt->execute()) {
  http_response_code(404);
  die("Not found");
}

$res = $stmt->fetch();

echo json_encode(array(
  "unlocked" => ($res[0] > 0)
));

?>
