
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../php/access_control.php';
$accessControl = new AccessControl();
$userManagement = new UserManagement();

//create database connection (needs to be done before mysql_real_escape_string)
$conn = require '../php/db_connect.php';

$user_sub = $_SESSION['sub'];
$user = $userManagement->readUser($user_sub)->id;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action');
    $value = filter_input(INPUT_POST, 'value');
    $widget_url = filter_input(INPUT_POST, 'widget_url');
    if ($widget_url) {
      // compute $unit id
      $statement = $conn->prepare("
        SELECT unit_id
        FROM course_elements
        WHERE widget_role_url = :widget_url
      ");
      $statement->bindParam(":widget_url", $widget_url, PDO::PARAM_INT);
      $statement->execute();
      $unit = $statement->fetch(PDO::FETCH_ASSOC)["unit_id"];
    }

    // Get timestamp of last progress submission
    $statement = $conn->prepare("
      SELECT *
      FROM user_progression
      WHERE user_id = :user and unit_id = :unit
    ");
    $statement->bindParam(":user", $user, PDO::PARAM_INT);
    $statement->bindParam(":unit", $unit, PDO::PARAM_INT);
    $statement->execute();
    $last_submission = $statement->fetch(PDO::FETCH_ASSOC);

    if ($last_submission) {
      if (time() - strtotime($last_submission['last_updated']) >= 60) {
        // update submission if at least 60 seconds passed since last update
        $statement = $conn->prepare("UPDATE `user_progression` SET `duration`= :duration, `last_updated` = CURRENT_TIMESTAMP WHERE `unit_id` = :unit and `user_id` = :user");
        $statement->bindParam(":user", $user, PDO::PARAM_INT);
        $statement->bindParam(":unit", $unit, PDO::PARAM_INT);
        $new_duration = $last_submission["duration"] + 1;
        print $new_duration;
        $statement->bindParam(":duration", $new_duration, PDO::PARAM_INT);
        $statement->execute();
      }
    } else {
      $statement = $conn->prepare("INSERT INTO `user_progression` (`unit_id`, `duration`, `last_updated`, `user_id`) VALUES (:unit, 1, CURRENT_TIMESTAMP, :user)");
      $statement->bindParam(":user", $user, PDO::PARAM_INT);
      $statement->bindParam(":unit", $unit, PDO::PARAM_INT);
      $statement->execute();
    }

    if ($action) {
      // Submit also a user_action
      $statement = $conn->prepare("INSERT INTO `user_actions` (`user_id`, `action`, `value`, `time`, `unit_id`) VALUES (:user, :action, :value, CURRENT_TIMESTAMP, :unit)");
      $statement->bindParam(":user", $user, PDO::PARAM_INT);
      $statement->bindParam(":unit", $unit, PDO::PARAM_INT);
      $statement->bindParam(":action", $action, PDO::PARAM_STR);
      $statement->bindParam(":value", $value, PDO::PARAM_STR);

      $success = $statement->execute();
      if (!$success) {
          print_r($statement->errorInfo());
          die("Error saving course.");
      }
    }
} else {
    die('Unsupported request type!');
}

?>
