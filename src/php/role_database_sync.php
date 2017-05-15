<?php

require_once '../config/config.php';
require_once '../php/tools.php';
require_once '../php/role_api.php';

class RoleSync {
  private $api;
  private $conn;

  public function __construct() {
    $this->api = new RoleAPI("http://virtus-vet.eu:8081/", getAdminToken());
    $this->conn = require '../php/db_connect.php';
  }

  public function createCourseSpace($course_id, $force = false) {
    // get course information
    $statement = $this->conn->prepare("SELECT space_url, name FROM courses, courses_lng WHERE courses.id = :course_id AND courses.id = courses_lng.course_id AND courses.default_lang = courses_lng.lang");
    $statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching space information.");
    }
    $course_data = $statement->fetch(PDO::FETCH_ASSOC);

    // check if already created
    if ($course_data['space_url'] != null && !$force) return;

    // create role space
    $space_name = $course_id . strtolower(urlencode(str_replace(' ', '',$course_data['name'])));
    $space_url = $this->api->createSpace($space_name);
    if ($space_url == -1) {
      die("Cannot create space!");
    }

    // add to database
    $statement = $this->conn->prepare("UPDATE courses SET space_url= :role_url WHERE id=:course_id");
    $statement->bindParam(":role_url", $space_name, PDO::PARAM_STR);
    $statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
        print_r($statement->errorInfo());
        die("Error updating role url.");
    }
  }

  function createUnitActivity($unit_id) {
    // get unit information
    $statement = $this->conn->prepare(
      "SELECT space_url, course_units_lng.title, activity_url
      FROM courses, course_units, course_units_lng
      WHERE course_units.id = :unit_id AND
            courses.id = course_units.course_id AND
            course_units.id = course_units_lng.unit_id AND course_units.default_lang = course_units_lng.lang");
    $statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching activity information.");
    }
    $unit_data = $statement->fetch(PDO::FETCH_ASSOC);

    // check if already created
    if ($unit_data['activity_url'] != null) return;

    // create activity
    $activity = $this->api->addActivityToSpace($unit_data['space_url'], $unit_data['title']);
    if ($activity == -1) {
      die("Cannot create activity!");
    }

    // add to database
    $statement = $this->conn->prepare("UPDATE course_units SET activity_url= :activity_url WHERE id=:unit_id");
    $statement->bindParam(":activity_url", $activity, PDO::PARAM_STR);
    $statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
        print_r($statement->errorInfo());
        die("Error updating activity url.");
    }
  }

  function destroyUnitActivity($unit_id) {
    // get activity url
    $stmt = $this->conn->prepare("SELECT activity_url FROM course_units WHERE course_units.id = :unit_id");
    $stmt->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
      print_r($stmt->errorInfo());
      die("Error fetching activity information.");
    }
    $activity_url = $stmt->fetch()[0];

    // check if actually exists
    if ($activity_url == null) return;

    // delete from space
    $result = $this->api->removeActivityFromSpace($activity_url);
    if ($result == -1) {
        die("Cannot remove activity from space!");
    }

    // delete from db
    $stmt = $this->conn->prepare("UPDATE course_units SET activity_url=NULL WHERE course_units.id = :unit_id");
    $stmt->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
      print_r($stmt->errorInfo());
      die("Error updating activity url.");
    }

    $stmt = $this->conn->prepare("UPDATE course_elements SET widget_role_url=NULL WHERE unit_id = :unit_id");
    $stmt->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
      print_r($stmt->errorInfo());
      die("Error updating widget urls.");
    }
  }

  function createElementWidget($element_id) {
    // get element information
    $statement = $this->conn->prepare(
      "SELECT space_url, activity_url, widget_role_url, widget_type
      FROM courses, course_units, course_elements
      WHERE course_elements.id = :element_id AND
            course_units.id = course_elements.unit_id AND
            courses.id = course_units.course_id");
    $statement->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching element information.");
    }
    $element_data = $statement->fetch(PDO::FETCH_ASSOC);

    // check if already created
    if ($element_data['widget_role_url'] != null) return;

    // create widget
    $widget_xml = getWidgetXML($element_data['widget_type']);
    $widget_role_url = $this->api->addWidgetToSpace($element_data['space_url'], $element_data['activity_url'], $widget_xml);
    if ($widget_role_url == -1) {
      die("Cannot create widget!");
    }

    // add to database
    $statement = $this->conn->prepare("UPDATE course_elements SET widget_role_url= :widget_role_url WHERE id=:element_id");
    $statement->bindParam(":widget_role_url", $widget_role_url, PDO::PARAM_STR);
    $statement->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
        print_r($statement->errorInfo());
        die("Error updating widget url.");
    }
  }

  function destroyElementWidget($element_id) {
    // get element url
    $stmt = $this->conn->prepare("SELECT widget_role_url FROM course_elements WHERE course_elements.id = :element_id");
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
      print_r($stmt->errorInfo());
      die("Error fetching element information.");
    }
    $widget_role_url = $stmt->fetch()[0];

    // check if actually exists
    if ($widget_role_url == null) return;

    // delete from space
    $result = $this->api->removeWidgetFromSpace($widget_role_url);
    if ($result == -1) {
        die("Cannot remove widget from activity!");
    }

    // delete from db
    $stmt = $this->conn->prepare("UPDATE course_elements SET widget_role_url=NULL WHERE course_elements.id = :element_id");
    $stmt->bindParam(":element_id", $element_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
      print_r($stmt->errorInfo());
      die("Error updating widget url.");
    }
  }

  /**
  * Rearranges widgets in the activity.
  */
  function updateUnitActivityWidgets($unit_id) {
    // get unit information
    $statement = $this->conn->prepare(
      "SELECT space_url, activity_url
      FROM courses, course_units
      WHERE course_units.id = :unit_id AND
            courses.id = course_units.course_id");
    $statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching activity information.");
    }
    $unit_data = $statement->fetch(PDO::FETCH_ASSOC);

    // check if activity exists
    if ($unit_data['space_url'] == null || $unit_data['activity_url'] == null) return;

    // get widget information
    $statement = $this->conn->prepare(
      "SELECT id, width, height, x, y, widget_role_url
      FROM course_elements
      WHERE unit_id = :unit_id");
    $statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching widget information.");
    }
    $widget_data = $statement->fetchAll(PDO::FETCH_ASSOC);

    // update space
    $this->api->moveWidgets($unit_data['space_url'],$unit_data['activity_url'], $widget_data);
  }

  function recreateRole() {
    /*
    * Note that the ROLE instance must be emtpy to perform this operation!
    */

    // recreate spaces
    $statement = $this->conn->prepare("SELECT id FROM courses");
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching course information.");
    }
    while($course = $statement->fetch(PDO::FETCH_ASSOC)) {
      $this->recreateCourseSpace($course['id']);
    }
  }

  function recreateCourseSpace($course_id) {
    /*
    * Note that if there are "lost" activities without any reference from the database,
    * they will still resist after recreation, because a space cannot be completely destroyed
    */

    // create if not exists
    $this->createCourseSpace($course_id);

    // recreate activities
    $statement = $this->conn->prepare("SELECT id FROM course_units WHERE course_id = :course_id");
    $statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching unit information.");
    }
    while($unit = $statement->fetch(PDO::FETCH_ASSOC)) {
      $this->recreateUnitActivity($unit['id']);
    }
  }

  function recreateUnitActivity($unit_id) {
    // clean / recreate activity
    $this->destroyUnitActivity($unit_id);
    $this->createUnitActivity($unit_id);

    // recreate widgets
    $statement = $this->conn->prepare("SELECT id FROM course_elements WHERE unit_id = :unit_id");
    $statement->bindParam(":unit_id", $unit_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching element information.");
    }
    while($element = $statement->fetch(PDO::FETCH_ASSOC)) {
      $this->createElementWidget($element['id']);
    }

    // rearrange them
    $this->updateUnitActivityWidgets($unit_id);
  }
}
?>
