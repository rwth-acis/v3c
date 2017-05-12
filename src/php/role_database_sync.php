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

  public function createCourseSpace($course_id) {
    // get course information
    $statement = $this->conn->prepare("SELECT name FROM courses, courses_lng WHERE courses.id = :course_id AND courses.id = courses_lng.course_id AND courses.default_lang = courses_lng.lang");
    $statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
      print_r($statement->errorInfo());
      die("Error fetching space information.");
    }
    $course_data = $statement->fetch(PDO::FETCH_ASSOC);

    // create role space
    $this->api->createSpace($course_id . strtolower(urlencode(str_replace(' ', '',$course_data['name']))));
    $role_url = $course_id . strtolower(urlencode(str_replace(' ', '',$course_data['name'])));

    // add to database
    $statement = $this->conn->prepare("UPDATE courses SET space_url= :role_url WHERE id=:course_id");
    $statement->bindParam(":role_url", $role_url, PDO::PARAM_STR);
    $statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    if (!$statement->execute()) {
        print_r($statement->errorInfo());
        die("Error updating role url.");
    }
  }

  function createUnitActivity() {
    // TODO
  }

  function destroyUnitActivity() {
    // TODO
  }

  function createElementWidget() {
    // TODO
  }

  function updateElementWidget() {
    // TODO
  }

  function destroyElementWidget() {
    // TODO
  }
}
?>
