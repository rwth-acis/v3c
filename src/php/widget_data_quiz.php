<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = require '../php/db_connect.php';

$widget_role_url = filter_input(INPUT_GET, 'widget_role_url');
$lang = filter_input(INPUT_GET, 'lang');

$stmt = $conn->prepare("SELECT widget_data_quiz_lng.element_id, title, lang
                        FROM widget_data_quiz_lng, course_elements
                        WHERE widget_data_quiz_lng.element_id = course_elements.id
                          AND lang = (SELECT IFNULL( (SELECT lang FROM widget_data_quiz_lng WHERE lang = :lang AND element_id = course_elements.id), course_elements.default_lang ))
                          AND widget_role_url = :widget_role_url");
$stmt->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_INT);
$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
if (!$stmt->execute()) {
  http_response_code(404);
  die("Error.");
}

$data = $stmt->fetch();
if (!is_array($data)) {
  http_response_code(404);
  die("Not found");
}


$questions = array();
$stmt = $conn->prepare("SELECT * FROM widget_data_quiz_questions, widget_data_quiz_questions_lng
                          WHERE element_id = :element_id AND widget_data_quiz_questions.id = widget_data_quiz_questions_lng.question_id
                          AND lang = (SELECT IFNULL( (SELECT lang FROM widget_data_quiz_questions_lng WHERE lang = :lang AND question_id = widget_data_quiz_questions.id), widget_data_quiz_questions.default_lang ))
                          ORDER BY `order`");
$stmt->bindParam(":element_id", $data['element_id'], PDO::PARAM_INT);
$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
if (!$stmt->execute()) {
  http_response_code(404);
  die("Error.");
}

$data2 = $stmt->fetchAll();

foreach ($data2 as $q) {
  $answers = array();
  $stmt = $conn->prepare("SELECT * FROM widget_data_quiz_answers, widget_data_quiz_answers_lng
                            WHERE question_id = :question_id AND widget_data_quiz_answers.id = widget_data_quiz_answers_lng.answer_id
                            AND lang = (SELECT IFNULL( (SELECT lang FROM widget_data_quiz_answers_lng WHERE lang = :lang AND answer_id = widget_data_quiz_answers.id), widget_data_quiz_answers.default_lang ))
                            ORDER BY `order`");
  $stmt->bindParam(":question_id", $q["id"], PDO::PARAM_INT);
  $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
  if (!$stmt->execute()) {
    http_response_code(404);
    die("Error.");
  }

  $data1 = $stmt->fetchAll();


  foreach ($data1 as $a) {
    $answers[$a["order"]] = array(
      "id" => $a["id"],
      "title" => $a["title"],
      "img" => $a["img"] //,
      // "correct" => ($a["correct"] ? "correct" : "")
    );
  }

  $questions[$q["order"]] = array(
    "id" => $q["id"],
    "title" => $q["title"],
    "img" => $q["img"],
    "answers" => $answers
  );
}

$res = array(
  "id" => $data["element_id"],
  "title" => $data["title"],
  "questions" => $questions
);

echo json_encode($res);

?>
