<?php

// Create database connection
$conn = require '../php/db_connect.php';


//Get input data from form
$course_id = filter_input(INPUT_GET, 'courseid', FILTER_VALIDATE_INT);
$unit_id = filter_input(INPUT_GET, 'unitid', FILTER_VALIDATE_INT);
$unit_lang = filter_input(INPUT_GET, 'unitlang');
$store = isset($_GET['store']);


// [{"widget":{"type":"slides"},"x":"1","y":"8","width":"4","height":"4"},{"widget":{"type":"video"},"x":"6","y":"8","width":"4","height":"4"},{"widget":{"type":"quiz"},"x":"3","y":"4","width":"4","height":"4"},{"widget":{"type":"hangout"},"x":"6","y":"0","width":"4","height":"4"}]


if ($store) { // store to db
  $inputJSON = file_get_contents('php://input');
  $input = json_decode($inputJSON, TRUE);

  $current_ids = array();

  foreach ($input as $element) {
    if (!array_key_exists('element_id', $element)) { // create course element
      $stmt = $conn->prepare("INSERT INTO course_elements (widget_type, x, y, width, height) VALUES (:type, :x, :y, :width, :height)");
      $stmt->bindParam(":type", $element['widget']['type'], PDO::PARAM_STR);
      $stmt->bindParam(":x", $element['x'], PDO::PARAM_INT);
      $stmt->bindParam(":y", $element['y'], PDO::PARAM_INT);
      $stmt->bindParam(":width", $element['width'], PDO::PARAM_INT);
      $stmt->bindParam(":height", $element['height'], PDO::PARAM_INT);

      $success = $stmt->execute();
      if (!$success) {
          http_response_code(400);
          print_r($stmt->errorInfo());
          die("Error saving course element.");
      }

      $element_id = $conn->lastInsertId();

      $stmt2 = $conn->prepare("INSERT INTO unit_to_element (unit_id, element_id) VALUES (:unit_id, :element_id)");
      $stmt2->bindParam(":unit_id", $unit_id);
      $stmt2->bindParam(":element_id", $element_id);

      $success = $stmt2->execute();
      if (!$success) {
          http_response_code(400);
          print_r($stmt2->errorInfo());
          die("Error connecting course element to unit.");
      }

      $current_ids[] = $element_id;
    }
    else { // update course element
      $stmt = $conn->prepare("UPDATE course_elements SET widget_type = :type, x = :x, y = :y, width = :width, height = :height WHERE id = :id");
      $stmt->bindParam(":id", $element['element_id'], PDO::PARAM_INT);
      $stmt->bindParam(":type", $element['widget']['type'], PDO::PARAM_STR);
      $stmt->bindParam(":x", $element['x'], PDO::PARAM_INT);
      $stmt->bindParam(":y", $element['y'], PDO::PARAM_INT);
      $stmt->bindParam(":width", $element['width'], PDO::PARAM_INT);
      $stmt->bindParam(":height", $element['height'], PDO::PARAM_INT);

      $success = $stmt->execute();
      if (!$success) {
          http_response_code(400);
          print_r($stmt->errorInfo());
          die("Error saving course element.");
      }

      $current_ids[] = $element['element_id'];
    }

    // TODO update/create widget with lang

    if (array_key_exists('element_id', $element)) {
      // TODO other langs ...
    }

  }

  // delete course elements
  $query_str = "";
  foreach ($current_ids as $id) {
    $query_str .= " AND id != " . $id;
  }

  $stmt = $conn->prepare("DELETE FROM course_elements WHERE id IN (SELECT id FROM unit_to_element WHERE unit_id = $unit_id) " . $query_str);
  $success = $stmt->execute();
  if (!$success) {
      http_response_code(400);
      print_r($stmt->errorInfo());
      die("Error deleting course elements.");
  }
}

// load from db
$elements = $conn->query("SELECT * FROM course_elements, unit_to_element WHERE course_elements.id = unit_to_element.element_id AND unit_to_element.unit_id = $unit_id")->fetchAll();
$results = array();
foreach ($elements as $el) {
  $results[] = array(
    "element_id" => $el['id'],
    "x" => $el['x'],
    "y" => $el['y'],
    "width" => $el['width'],
    "height" => $el['height'],
    "widget" => array(
      "type" => $el['widget_type']
    )
  );
}

echo json_encode($results);

?>
