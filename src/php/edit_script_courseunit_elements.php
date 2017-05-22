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
// require '../php/tools.php';

require '../php/role_database_sync.php';
$role = new RoleSync();



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
  'image' => function($conn, $element_id, $lang, $data) {
    $query = "REPLACE INTO widget_data_image_lng (element_id,lang,title,link) VALUES (:element_id, :lang, :title, :link)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    $stmt->bindValue(":title", (isset($data['title']) ? $data['title'] : ""), PDO::PARAM_STR);
    $stmt->bindValue(":link", (isset($data['link']) ? $data['link'] : ""), PDO::PARAM_STR);

    if (!$stmt->execute()) {
      http_response_code(400);
      print_r($stmt->errorInfo());
      die("Error saving image data.");
    }
  },
  'feedback' => function($conn, $element_id, $lang, $data) {
    $query = "REPLACE INTO widget_data_feedback_lng (element_id,lang,title,`text`) VALUES (:element_id, :lang, :title, :text)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    $stmt->bindValue(":title", (isset($data['title']) ? $data['title'] : ""), PDO::PARAM_STR);
    $stmt->bindValue(":text", (isset($data['text']) ? $data['text'] : ""), PDO::PARAM_STR);

    if (!$stmt->execute()) {
      http_response_code(400);
      print_r($stmt->errorInfo());
      die("Error saving feedback data.");
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
     $query = "REPLACE INTO widget_data_quiz_lng (element_id,lang,title) VALUES (:element_id, :lang, :title)";
     $stmt = $conn->prepare($query);
     $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
     $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
     $stmt->bindValue(":title", (isset($data['title']) ? $data['title'] : ""), PDO::PARAM_STR);

     if (!$stmt->execute()) {
       http_response_code(400);
       print_r($stmt->errorInfo());
       die("Error saving slides data.");
     }

    // STORE QUESTIONS

     $current_question_ids = array();
     $question_order = 0;
     foreach ($data['questions'] as $question) {
       $question_id = -1;
       if (!isset($question['id']) || $question['id'] == "") {
         $stmt = $conn->prepare("INSERT INTO widget_data_quiz_questions (element_id, `order`, default_lang) VALUES (:element_id, :order, :lang)");
         $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
         $stmt->bindParam(":order", $question_order, PDO::PARAM_INT);
         $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);

         if (!$stmt->execute()) {
           http_response_code(400);
           print_r($stmt->errorInfo());
           die("Error.");
         }

         $question_id = $conn->lastInsertId();
       }
       else {
         $stmt = $conn->prepare("UPDATE widget_data_quiz_questions SET `order` = :order WHERE id = :id");
         $stmt->bindParam(":id", $question['id'], PDO::PARAM_INT);
         $stmt->bindParam(":order", $question_order, PDO::PARAM_INT);

         if (!$stmt->execute()) {
           http_response_code(400);
           print_r($stmt->errorInfo());
           die("Error.");
         }

         $question_id = $question['id'];
       }

       $current_question_ids[] = $question_id;

       $query = "REPLACE INTO widget_data_quiz_questions_lng (question_id,lang,title,img) VALUES (:question_id, :lang, :question, :img)";
       $stmt = $conn->prepare($query);
       $stmt->bindParam(":question_id", $question_id, PDO::PARAM_INT);
       $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
       $stmt->bindValue(":question", (isset($question['title']) ? $question['title'] : ""), PDO::PARAM_STR);
       $stmt->bindValue(":img", (isset($question['img']) ? $question['img'] : ""), PDO::PARAM_STR);

       if (!$stmt->execute()) {
         http_response_code(400);
         print_r($stmt->errorInfo());
         die("Error.");
       }

       // STORE answers

       $current_answer_ids = array();
       $answer_order = 0;
       foreach ($question['answers'] as $answer) {
         $answer_id = -1;
         if (!isset($answer['id']) || $answer['id'] == "") {
           $stmt = $conn->prepare("INSERT INTO widget_data_quiz_answers (question_id, `order`, correct, default_lang) VALUES (:question_id, :order, :correct, :lang)");
           $stmt->bindParam(":question_id", $question_id, PDO::PARAM_INT);
           $stmt->bindParam(":order", $answer_order, PDO::PARAM_INT);
           $stmt->bindValue(":correct", $answer['correct'] == "correct", PDO::PARAM_INT);
           $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);

           if (!$stmt->execute()) {
             http_response_code(400);
             print_r($stmt->errorInfo());
             die("Error.");
           }

           $answer_id = $conn->lastInsertId();
         }
         else {
           $stmt = $conn->prepare("UPDATE widget_data_quiz_answers SET `order` = :order, correct = :correct WHERE id = :id");
           $stmt->bindParam(":id", $answer['id'], PDO::PARAM_INT);
           $stmt->bindParam(":order", $answer_order, PDO::PARAM_INT);
           $stmt->bindValue(":correct", $answer['correct'] == "correct", PDO::PARAM_INT);

           if (!$stmt->execute()) {
             http_response_code(400);
             print_r($stmt->errorInfo());
             die("Error.");
           }

           $answer_id = $answer['id'];
         }

         $current_answer_ids[] = $answer_id;

         $query = "REPLACE INTO widget_data_quiz_answers_lng (answer_id,lang,title,img) VALUES (:answer_id, :lang, :answer, :img)";
         $stmt = $conn->prepare($query);
         $stmt->bindParam(":answer_id", $answer_id, PDO::PARAM_INT);
         $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
         $stmt->bindValue(":answer", (isset($answer['title']) ? $answer['title'] : ""), PDO::PARAM_STR);
         $stmt->bindValue(":img", (isset($answer['img']) ? $answer['img'] : ""), PDO::PARAM_STR);

         if (!$stmt->execute()) {
           http_response_code(400);
           print_r($stmt->errorInfo());
           die("Error.");
         }

         $answer_order ++;
       }

       $query_str = "";
       foreach ($current_answer_ids as $id) {
         $query_str .= " AND id != " . $id;
       }

       $stmt = $conn->prepare("DELETE FROM widget_data_quiz_answers WHERE question_id = ". $question_id ." " . $query_str);
       if (!$stmt->execute()) {
         http_response_code(400);
         print_r($stmt->errorInfo());
         die("Error.");
       }

       // END STORE ANSWERS

       $question_order ++;
     }

     $query_str = "";
     foreach ($current_question_ids as $id) {
       $query_str .= " AND id != " . $id;
     }

     $stmt = $conn->prepare("DELETE FROM widget_data_quiz_questions WHERE element_id = ". $element_id ." " . $query_str);
     if (!$stmt->execute()) {
       http_response_code(400);
       print_r($stmt->errorInfo());
       die("Error.");
     }
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
  'image' => function($conn, $element_id, $lang) {
    $stmt = $conn->prepare("SELECT * FROM widget_data_image_lng WHERE element_id = :element_id AND lang = :lang LIMIT 1");
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
  'feedback' => function($conn, $element_id, $lang) {
    $stmt = $conn->prepare("SELECT * FROM widget_data_feedback_lng WHERE element_id = :element_id AND lang = :lang LIMIT 1");
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
        "text" => $data["text"]
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
    $stmt = $conn->prepare("SELECT * FROM widget_data_quiz_lng WHERE element_id = :element_id AND lang = :lang LIMIT 1");
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
    if (!$stmt->execute()) {
      echo "Error.";
    } else {
      $data = $stmt->fetch();
    }

    if (is_array($data))  {
      $questions = array();
      $stmt = $conn->prepare("SELECT * FROM widget_data_quiz_questions, widget_data_quiz_questions_lng
                                WHERE element_id = :element_id AND widget_data_quiz_questions.id = widget_data_quiz_questions_lng.question_id
                                AND lang = (SELECT IFNULL( (SELECT lang FROM widget_data_quiz_questions_lng WHERE lang = :lang AND question_id = widget_data_quiz_questions.id), widget_data_quiz_questions.default_lang ))
                                ORDER BY `order`");
      $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
      $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
      if (!$stmt->execute()) {
        echo "Error.";
      } else {
        $data2 = $stmt->fetchAll();
      }

      foreach ($data2 as $q) {
        $answers = array();
        $stmt = $conn->prepare("SELECT * FROM widget_data_quiz_answers, widget_data_quiz_answers_lng
                                  WHERE question_id = :question_id AND widget_data_quiz_answers.id = widget_data_quiz_answers_lng.answer_id
                                  AND lang = (SELECT IFNULL( (SELECT lang FROM widget_data_quiz_answers_lng WHERE lang = :lang AND answer_id = widget_data_quiz_answers.id), widget_data_quiz_answers.default_lang ))
                                  ORDER BY `order`");
        $stmt->bindParam(":question_id", $q["id"], PDO::PARAM_INT);
        $stmt->bindParam(":lang", $lang, PDO::PARAM_STR);
        if (!$stmt->execute()) {
          echo "Error.";
        } else {
          $data1 = $stmt->fetchAll();
        }

        foreach ($data1 as $a) {
          $answers[$a["order"]] = array(
            "id" => $a["id"],
            "title" => $a["title"],
            "img" => $a["img"],
            "correct" => ($a["correct"] ? "correct" : "")
          );
        }

        $questions[$q["order"]] = array(
          "id" => $q["id"],
          "title" => $q["title"],
          "img" => $q["img"],
          "answers" => $answers
        );
      }

      return array(
        "title" => $data["title"],
        "questions" => $questions
      );
    }
    else {
      return false;
    }
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
      // store to DB
      $stmt = $conn->prepare("INSERT INTO course_elements (widget_type, x, y, width, height, default_lang, widget_role_url, unit_id) VALUES (:type, :x, :y, :width, :height, :lang, :widget_role_url, :unit_id)");
      $stmt->bindParam(":type", $element['widget']['type'], PDO::PARAM_STR);
      $stmt->bindParam(":x", $element['x'], PDO::PARAM_INT);
      $stmt->bindParam(":y", $element['y'], PDO::PARAM_INT);
      $stmt->bindParam(":width", $element['width'], PDO::PARAM_INT);
      $stmt->bindParam(":height", $element['height'], PDO::PARAM_INT);
      $stmt->bindParam(":lang", $unit_lang, PDO::PARAM_INT);
      $stmt->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_STR);
      $stmt->bindParam(":unit_id", $unit_id);

      $success = $stmt->execute();
      if (!$success) {
        http_response_code(400);
        print_r($stmt->errorInfo());
        die("Error saving course element.");
      }

      $element_id = $conn->lastInsertId();
      $current_ids[] = $element_id;

      // create widget
      $role->createElementWidget($element_id);
    }
    else { // update course element
      $widget = getSingleDatabaseEntryByValue('course_elements','id',$element['element_id']);

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

  // destroy widgets
  $query_str = "";
  foreach ($current_ids as $id) {
    $query_str .= " AND id != " . $id;
  }
  $stmt = $conn->prepare("SELECT id FROM course_elements WHERE unit_id = $unit_id " . $query_str);
  if (!$stmt->execute()) {
    http_response_code(400);
    print_r($stmt->errorInfo());
    die("Error.");
  }
  while ($w = $stmt->fetch()) {
    $role->destroyElementWidget($w['id']);
  }

  // delete elements from DB
  $stmt = $conn->prepare("DELETE FROM course_elements WHERE unit_id = $unit_id " . $query_str);
  if (!$stmt->execute()) {
    http_response_code(400);
    print_r($stmt->errorInfo());
    die("Error deleting course elements.");
  }

  // move widgets in space
  $role->updateUnitActivityWidgets($unit_id);
}

// load from db
$elements = $conn->query("SELECT * FROM course_elements WHERE course_elements.unit_id = $unit_id")->fetchAll();
$results = array();
foreach ($elements as $el) {
  $widget_data = $loadWidgetData[$el['widget_type']]($conn, $el['id'], $unit_lang);
  if ($widget_data == false) {
    $widget_data = $loadWidgetData[$el['widget_type']]($conn, $el['id'], $el['default_lang']);
  }

  $widget_data["type"] = $el['widget_type'];

  $results[] = array(
    "element_id" => $el['id'],
    "x" => $el['x'],
    "y" => $el['y'],
    "width" => $el['width'],
    "height" => $el['height'],
    "widget" => $widget_data,
    "flow" => "true" // TODO
    );
}

echo json_encode($results);



?>
