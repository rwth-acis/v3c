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
    $api = new RoleAPI("http://virtus-vet.eu:8081/", getAdminToken());
    $result = $api->removeActivityFromSpace($activity_url);
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
  }

  function createElementWidget() {
    // TODO edit_script_courseunit_elements.php ...
  }

  function updateElementWidget() {
    // TODO edit_script_courseunit_elements.php ...
  }

  function destroyElementWidget() {
    // TODO edit_script_courseunit_elements.php ...
  }
}
?>
