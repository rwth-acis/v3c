<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}

$conn = require '../php/db_connect.php';

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

// write submission
$store = isset($_GET['store']);
if ($store) {
  $inputText = file_get_contents('php://input');

  $stmt = $conn->prepare("REPLACE INTO widget_data_feedback_submissions (user_id, element_id, content) VALUES (:user_id, :element_id, :content)");
  $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
  $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
  $stmt->bindParam(":content", $inputText, PDO::PARAM_STR);
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Error.");
  }
}

// read submissions
$result = array();

$stmt = $conn->prepare("SELECT content FROM widget_data_feedback_submissions WHERE element_id = :element_id AND user_id = :user_id");
$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
$stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
if (!$stmt->execute()) {
  http_response_code(404);
  die("Error.");
}

$data = $stmt->fetch();

echo $data["content"];

?>
