<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = require '../php/db_connect.php';

$widget_role_url = filter_input(INPUT_GET, 'widget_role_url');

$stmt = $conn->prepare("SELECT this.widget_flow_order AS this_order, next.widget_role_url AS next_widget, next.widget_type AS next_type, next.id AS next_id
                        FROM course_elements AS this
                        LEFT JOIN course_elements AS next ON next.widget_flow_order = (this.widget_flow_order + 1)
                        WHERE this.widget_role_url = :widget_role_url");
$stmt->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_STR);
if (!$stmt->execute()) {
  http_response_code(404);
  die("Not found");
}

$res = $stmt->fetch();

echo json_encode(array(
  "order" => $res['this_order'],
  "next_widget" => $res['next_widget'],
  "next_type" => $res['next_type'],
  "next_id" => $res['next_id']
));

?>
