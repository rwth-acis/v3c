<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 11/12/2016
 * Time: 12:54
 */
class CourseUnitMapper extends Mapper
{
    /**
     *
     * Get all the course_units for certain course
     *
     * @param $course_id
     * @return array
     */
    public function getCourseUnits($course_id)
    {
        $course_units_sql = "SELECT DISTINCT course_units.* 
                             FROM course_units JOIN course_to_unit AS ctu 
                             ON ctu.course_id = $course_id";


        $stmt = $this->db->query($course_units_sql);

        $course_units = [];

        while ($row = $stmt->fetch()) {
            $course_units[] = new CourseUnit($row);
        }
        return $course_units;
    }

    public function getCourseUnitsByIdAndLang($course_id, $course_lang)
    {
        $conn = require '../php/db_connect.php';
        // Get course units
        $stmt = $conn->prepare("SELECT course_units.*
                                FROM courses 
                                JOIN course_to_unit 
                                ON courses.id = course_to_unit.course_id 
                                  AND courses.lang = course_to_unit.course_lang
                                JOIN course_units 
                                ON course_to_unit.unit_id = course_units.id 
                                  AND course_to_unit.unit_lang = course_units.lang
                                WHERE courses.id = :course_id
                                  AND course_units.lang = :course_lang");

        $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
        $stmt->bindParam(":course_lang", $course_lang, PDO::PARAM_STR);
        $success = $stmt->execute();
        if ($success) {
            $course_units = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $course_units;
        }
    }

    public function getCourseUnitById($course_id, $course_unit_id)
    {
        $course_unit_sql = "SELECT course_units.* 
                            FROM course_units JOIN course_to_unit AS ctu ON ctu.course_id = :course_id
                            WHERE course_units.id = :course_unit_id";

        $stmt = $this->db->prepare($course_unit_sql);
        $result = $stmt->execute(["course_id" => $course_id, "course_unit_id" => $course_unit_id]);
        if ($result) {
            return new CourseUnit($stmt->fetch());
        }

    }

    public function save($course_id, $course_lang, CourseUnit $course_unit) {
        // Create database-entry
        $conn = require '../php/db_connect.php';
        $stmt = $conn->prepare("INSERT INTO course_units (title, lang, points, start_date, description) 
                             VALUES (:name, :lang, :points, :startdate, :description)");
        $stmt->bindParam(":name", $course_unit->getTitle(), PDO::PARAM_STR);
        $stmt->bindParam(":lang", $course_lang, PDO::PARAM_STR);  // course unit inherits course language
        $stmt->bindParam(":points", $course_unit->getPoints(), PDO::PARAM_INT);
        $stmt->bindParam(":startdate", $course_unit->getStartDate(), PDO::PARAM_STR);
        $stmt->bindParam(":description", $course_unit->getDescription(), PDO::PARAM_STR);

        $success = $stmt->execute();
        if (!$success) {
            print_r($stmt->errorInfo());
            die("Error saving course unit.");
        }

        $course_unit_id = $conn->lastInsertId();
        echo "course id: " . $course_id;
        echo "course lang: " . $course_lang;
        echo "cuid: " . $course_unit_id;

        $stmt2 = $conn->prepare("INSERT INTO course_to_unit (course_id, course_lang, unit_id, unit_lang) VALUES (:course_id, :course_lang, :cu_id, :cu_lang)");
        $stmt2->bindParam(":course_id", $course_id);
        $stmt2->bindParam(":course_lang", $course_lang);
        $stmt2->bindParam(":cu_id", $course_unit_id);
        $stmt2->bindParam(":cu_lang", $course_lang);

        $success = $stmt2->execute();
        if (!$success) {
            print_r($stmt2->errorInfo());
            die("Error connecting course unit to course.");
        }

        return array("course_id" => $course_id, "course_lang" => $course_lang);
    }


}