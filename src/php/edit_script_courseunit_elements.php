<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Create database connection
$conn = require '../php/db_connect.php';
require '../php/tools.php';
require '../php/role_api.php';



function get_languages($conn, $unit_id) {
  $statement = $conn->prepare("SELECT lang FROM course_units WHERE id = :unit_id");
  $statement->bindParam(":unit_id",$unit_id,PDO::PARAM_INT);
  if (!$statement->execute()) {
    print_r($statement->errorInfo());
    die("Error.");
  }
  $langs = $statement->fetchAll(PDO::FETCH_ASSOC);

  $result = array();
  foreach ($langs as $l) {
    $result[] = $l['lang'];
  }

  return $result;
}

$storeWidgetData = array(
  'slides' => function($conn, $element_id, $lang, $data) {
    $query = "REPLACE INTO widget_data_slides (element_id,lang,title,link) VALUES (:element_id, :lang, :title, :link)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    $stmt->bindValue(":title", (isset($data['title']) ? $data['title'] : ""), PDO::PARAM_STR);
    $stmt->bindValue(":link", (isset($data['link']) ? $data['link'] : ""), PDO::PARAM_STR);

    if (!$stmt->execute()) {
      http_response_code(400);
      print_r($stmt->errorInfo());
      die("Error saving slides data.");
    }
  },
  'video' => function($conn, $element_id, $lang, $data) {
    $query = "REPLACE INTO widget_data_video (element_id,lang,title,link) VALUES (:element_id, :lang, :title, :link)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    $stmt->bindValue(":title", (isset($data['title']) ? $data['title'] : ""), PDO::PARAM_STR);
    $stmt->bindValue(":link", (isset($data['link']) ? $data['link'] : ""), PDO::PARAM_STR);

    if (!$stmt->execute()) {
      http_response_code(400);
      print_r($stmt->errorInfo());
      die("Error saving slides data.");
    }
  },
  'hangout' => function($conn, $element_id, $lang, $data) {
  },
  'quiz' => function($conn, $element_id, $lang, $data) {
     // TODO
  }
  );

$loadWidgetData = array(
  'slides' => function($conn, $element_id, $lang) {
    $stmt = $conn->prepare("SELECT * FROM widget_data_slides WHERE element_id = :element_id AND lang = :lang LIMIT 1");
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    if (!$stmt->execute()) {
      echo "Error loading course.";
    } else {
      $data = $stmt->fetch();
    }

    if (is_array($data))  {
      return array(
        "title" => $data["title"],
        "link" => $data["link"]
        );
    }
    else {
      return false;
    }
  },
  'video' => function($conn, $element_id, $lang) {
    $stmt = $conn->prepare("SELECT * FROM widget_data_video WHERE element_id = :element_id AND lang = :lang LIMIT 1");
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    if (!$stmt->execute()) {
      echo "Error loading course.";
    } else {
      $data = $stmt->fetch();
    }

    if (is_array($data))  {
      return array(
        "title" => $data["title"],
        "link" => $data["link"]
        );
    }
    else {
      return false;
    }
  },
  'hangout' => function($conn, $element_id, $lang) {
    return array();
  },
  'quiz' => function($conn, $element_id, $lang) {
    // TODO
    return array();
  }
  );


//Get input data from form
$course_id = filter_input(INPUT_GET, 'courseid', FILTER_VALIDATE_INT);
$course = getSingleDatabaseEntryByValue('courses','id',$course_id);
$unit_id = filter_input(INPUT_GET, 'unitid', FILTER_VALIDATE_INT);
$unit = getSingleDatabaseEntryByValue('course_units','id',$unit_id);
$unit_lang = filter_input(INPUT_GET, 'unitlang');
$store = isset($_GET['store']);


if ($store) { // store to db
  $inputJSON = file_get_contents('php://input');
  $input = json_decode($inputJSON, TRUE);

  $current_ids = array();

  foreach ($input as $element) {
    $element_id = -1;
    if (!isset($element['element_id'])) { // create course element

      // Add widget to activity in role space
      // creating activity
      $api = new RoleAPI("http://virtus-vet.eu:8081/", $_SESSION['access_token']);
      $widgetXML = getWidgetXML($element['widget']['type']);
      $widget_role_url = $api->addWidgetToSpace($course['space_url'], $unit['activity_url'],$widgetXML);

      $stmt = $conn->prepare("INSERT INTO course_elements (widget_type, x, y, width, height, default_lang, widget_role_url) VALUES (:type, :x, :y, :width, :height, :lang, :widget_role_url)");
      $stmt->bindParam(":type", $element['widget']['type'], PDO::PARAM_STR);
      $stmt->bindParam(":x", $element['x'], PDO::PARAM_INT);
      $stmt->bindParam(":y", $element['y'], PDO::PARAM_INT);
      $stmt->bindParam(":width", $element['width'], PDO::PARAM_INT);
      $stmt->bindParam(":height", $element['height'], PDO::PARAM_INT);
      $stmt->bindParam(":lang", $unit_lang, PDO::PARAM_INT);
      $stmt->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_STR);

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
      $stmt = $conn->prepare("UPDATE course_elements SET x = :x, y = :y, width = :width, height = :height WHERE id = :id");
      $stmt->bindParam(":id", $element['element_id'], PDO::PARAM_INT);
      $stmt->bindParam(":x", $element['x'], PDO::PARAM_INT);
      $stmt->bindParam(":y", $element['y'], PDO::PARAM_INT);
      $stmt->bindParam(":width", $element['width'], PDO::PARAM_INT);
      $stmt->bindParam(":height", $element['height'], PDO::PARAM_INT);
      // widget type cannot be changed

      $success = $stmt->execute();
      if (!$success) {
        http_response_code(400);
        print_r($stmt->errorInfo());
        die("Error saving course element.");
      }

      $element_id = $element['element_id'];

      $current_ids[] = $element['element_id'];
    }

    // store widget data
    $storeWidgetData[$element['widget']['type']]($conn, $element_id, $unit_lang, $element['widget']);
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
  $widget_data = $loadWidgetData[$el['widget_type']]($conn, $el['id'], $unit_lang);
  if ($widget_data == false) {
    $widget_data = $loadWidgetData[$el['widget_type']]($conn, $el['id'], $el['default_lang']);
    // TODO mark as untranslated?!?
  }

  $widget_data["type"] = $el['widget_type'];

  $results[] = array(
    "element_id" => $el['id'],
    "x" => $el['x'],
    "y" => $el['y'],
    "width" => $el['width'],
    "height" => $el['height'],
    "widget" => $widget_data
    );
}

echo json_encode($results);



?>
