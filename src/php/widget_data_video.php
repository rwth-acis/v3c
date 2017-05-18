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

$stmt = $conn->prepare("SELECT widget_data_video.element_id, title, link, lang
                        FROM widget_data_video, course_elements
                        WHERE widget_data_video.element_id = course_elements.id
                          AND (lang = :lang OR lang = (SELECT default_lang FROM course_elements WHERE widget_role_url = :widget_role_url ))
                          AND widget_role_url = :widget_role_url");

$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
$stmt->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_STR);

if ($stmt->execute() !== FALSE) {
    $res = $stmt->fetchAll();

    if (count($res) == 1) {
      $res = $res[0];
    }
    else if (count($res) == 2 && $res[0]['lang'] == $lang) {
      $res = $res[0];
    }
    else if (count($res) == 2) { // && $res[1]['lang'] == $lang
      $res = $res[1];
    }
    else {
      http_response_code(404);
      die("Not found");
    }

    echo '{"element_id": '. $res['element_id'] .', "title": "'. $res['title'] .'", "link": "'. $res['link'] .'"}';
}
else {
  http_response_code(404);
  echo "Not found";
}

?>
