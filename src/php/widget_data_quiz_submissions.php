<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}

$conn = require '../php/db_connect.php';

$widget_role_url = filter_input(INPUT_GET, 'widget_role_url');

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

// element id
$stmt = $conn->prepare("SELECT id FROM course_elements WHERE widget_role_url = :widget_role_url");
$stmt->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_STR);
if (!$stmt->execute()) {
  http_response_code(500);
  die("Error.");
}
$data = $stmt->fetch();
if (!is_array($data)) {
  http_response_code(404);
  die("Quiz not found.");
}
$element_id = $data['id'];

// write submission
$store = isset($_GET['store']);
if ($store) {
  $inputJSON = file_get_contents('php://input');
  $input = json_decode($inputJSON, TRUE);

  $stmt = $conn->prepare("INSERT INTO widget_data_quiz_submissions (user_id, element_id) VALUES (:user_id, :element_id)");
  $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
  $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Error.");
  }


  foreach ($input['answers'] as $qid => $question) {
    foreach ($question as $aid => $answer) {
      $stmt = $conn->prepare("INSERT INTO widget_data_quiz_submissions_answers (user_id, answer_id, checked) VALUES (:user_id, :answer_id, :checked)");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindParam(":answer_id", $aid, PDO::PARAM_INT);
      $stmt->bindValue(":checked", $answer["checked"] ? 1 : 0, PDO::PARAM_INT);
      if (!$stmt->execute()) {
        http_response_code(500);
        die("Error.");
      }
    }
  }
}

// read submission
$stmt = $conn->prepare("SELECT date, element_id
                        FROM widget_data_quiz_submissions, course_elements
                        WHERE widget_data_quiz_submissions.element_id = course_elements.id
                          AND user_id = :user_id
                          AND widget_role_url = :widget_role_url");
$stmt->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_STR);
$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
if (!$stmt->execute()) {
  http_response_code(500);
  die("Error.");
}
$submission_data = $stmt->fetch();
if (!is_array($submission_data)) {
  echo '{"submitted": false}';
}
else {
  $answers = array();

  $stmt = $conn->prepare("SELECT question_id, answer_id, checked, correct FROM widget_data_quiz_submissions_answers, widget_data_quiz_questions, widget_data_quiz_answers
                            WHERE element_id = :element_id
                            AND user_id = :user_id
                            AND widget_data_quiz_questions.id = widget_data_quiz_answers.question_id
                            AND widget_data_quiz_answers.id = widget_data_quiz_submissions_answers.answer_id
                            ");
  $stmt->bindParam(":element_id", $submission_data['element_id'], PDO::PARAM_INT);
  $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
  if (!$stmt->execute()) {
    http_response_code(500);
    die("Error.");
  }

  $data2 = $stmt->fetchAll();
  foreach ($data2 as $a) {
    $answers[$a['question_id']][$a['answer_id']] = array(
      "checked" => $a['checked'] == "0" ? false : true,
      "correct" => $a['correct'] == "0" ? false : true
    );
  }

  echo json_encode(array(
    "submitted" => true,
    "date" => $submission_data['date'],
    "answers" => $answers
  ));
}



?>
