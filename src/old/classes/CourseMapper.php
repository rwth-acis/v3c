<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 09/12/2016
 * Time: 23:37
 */
class CourseMapper extends Mapper
{
    public function getCourses($args = array())
    {
        $courses_sql = "SELECT * FROM courses";
        if (!empty($args)) {
            $where_clause = " WHERE ";
            end($args);
            $key = key($args);
            foreach ($args as $k => $v) {
                if (!is_numeric($v)) {
                    $v = "" . $v . "";
                }
                if ($k == $key) {
                    $where_clause .= " " . $k . " = " . $v;
                } else {
                    $where_clause .= " " . $k . " = " . $v . " AND ";
                }
            }

            $courses_sql .= $where_clause;
        }

        $stmt = $this->db->query($courses_sql);

        $courses = [];

        while ($row = $stmt->fetch()) {

            $courses[] = new Course($row);
        }
        return $courses;
    }

    /**
     * Get one course by its ID
     *
     * @param int $course_id The ID of the ticket
     * @return Course  The course
     */
    public function getCoursesById($course_id)
    {
        $course_by_id_sql = "SELECT * FROM courses WHERE id = $course_id";
        $stmt = $this->db->query($course_by_id_sql);;

        $courses = [];
        while ($row = $stmt->fetch()) {

            $courses[] = new Course($row);
        }
        return $courses;
    }

    public function getCourseByIdAndLang($course_id, $course_lang)
    {
        $course_by_id_sql = "SELECT * FROM courses WHERE id = :course_id AND lang = :course_lang";
        $stmt = $this->db->prepare($course_by_id_sql);
        $result = $stmt->execute(["course_id" => $course_id, "course_lang" => $course_lang]);

        if ($result) {
            return array(new Course($stmt->fetch()));
        }
    }

    public function getCourseByQueryParams($params)
    {
        $where_clause = "";
        $last_param = end($params);
        foreach ($params as $k => $v) {
            if ($v == $last_param) {
                if (is_string($v)) {
                    $v = "'" . $v . "'";
                }
                $where_clause .= $k . " = " . $v;
            } else {
                $where_clause .= $k . " = " . $v . " AND ";
            }
        }
        $course_by_query_params = "SELECT * FROM courses WHERE $where_clause";

        $stmt = $this->db->query($course_by_query_params);

        $courses = [];

        while ($row = $stmt->fetch()) {
            $courses[] = new Course($row);
        }
        return $courses;
    }

    public function save(Course $course)
    {
        $conn = require '../php/db_connect.php';
        $statement = $conn->prepare("INSERT INTO courses 
                                            (lang, name, description, domain, profession, creator) 
                                     VALUES (:language, :name, :description, :domain, :profession, :creator)");
        $statement->bindParam(":language", $course->getLang(), PDO::PARAM_STR);
        $statement->bindParam(":name", $course->getName(), PDO::PARAM_STR);
        $statement->bindParam(":description", $course->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(":domain", $course->getDomain(), PDO::PARAM_INT);
        $statement->bindParam(":profession", $course->getProfession(), PDO::PARAM_STR);
        $statement->bindParam(":creator", $course->getCreator(), PDO::PARAM_STR);
        //$stmt = $this->db->prepare($sql);
        $success = $statement->execute();
        if (!$success) {
            print_r($statement->errorInfo());
            die("Error saving course.");
        }
        $course_id = $conn->lastInsertId();
        $course_lang = $course->getLang();

        return array("course_id" => $course_id, "course_lang" => $course_lang);

    }

    public function put($updated_fields)
    {
        // Create database connection
        $conn = require '../php/db_connect.php';

        $course_id = filter_var($updated_fields['courseid'], FILTER_SANITIZE_STRING);
        $creator = 'kpapavramidis@mastgroup.gr';
        $name = filter_var($updated_fields['name'], FILTER_SANITIZE_STRING);
        $domain = filter_var($updated_fields['domain'], FILTER_SANITIZE_NUMBER_INT);
        $profession = filter_var($updated_fields['profession'], FILTER_SANITIZE_STRING);
        $description = filter_var($updated_fields['description'], FILTER_SANITIZE_STRING);
        $language = filter_var($updated_fields['courselang'], FILTER_SANITIZE_STRING);

        // Create database-entry
        $statement = $conn->prepare("UPDATE courses 
                                    SET name = :name, 
                                      description = :description, 
                                      domain = :domain, 
                                      profession = :profession, 
                                      creator = :creator 
                                    WHERE courses.id = :course_id AND courses.lang = :course_lang");

        $statement->bindParam(":course_id", $course_id, PDO::PARAM_INT);
        $statement->bindParam(":course_lang", $language, PDO::PARAM_STR);
        $statement->bindParam(":name", $name, PDO::PARAM_STR);
        $statement->bindParam(":description", $description, PDO::PARAM_STR);
        $statement->bindParam(":domain", $domain, PDO::PARAM_INT);
        $statement->bindParam(":profession", $profession, PDO::PARAM_STR);
        $statement->bindParam(":creator", $creator, PDO::PARAM_STR);

        $success = $statement->execute();
        if (!$success) {
            print_r($statement->errorInfo());
            die("Error saving course.");
        }

        return array("course_id" => $course_id, "course_lang" => $language);
    }
}