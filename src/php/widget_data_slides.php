<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = require '../php/db_connect.php';

$widget_instance_url = filter_input(INPUT_GET, 'widget_instance_url');
$lang = filter_input(INPUT_GET, 'lang');

$stmt = $conn->prepare("SELECT widget_data_slides.element_id, title, link
                        FROM widget_data_slides, course_elements
                        WHERE widget_data_slides.element_id = course_elements.id
                          AND lang = :lang
                          AND widget_instance_url = :widget_instance_url
                        LIMIT 1");

$stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
$stmt->bindParam(":widget_instance_url", $widget_instance_url, PDO::PARAM_STR);

if ($stmt->execute() !== FALSE) {
    $res = $stmt->fetch();
    echo '{"element_id": '. $res['element_id'] .', "title": "'. $res['title'] .'", "link": "'. $res['link'] .'"}';
}
else {
  http_response_code(404);
  echo "Not found";
}

?>
