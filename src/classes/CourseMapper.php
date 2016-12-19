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
    public function getCourseById($course_id)
    {
        $course_by_id_sql = "SELECT * FROM courses WHERE id = :course_id";
        $stmt = $this->db->prepare($course_by_id_sql);
        $result = $stmt->execute(["course_id" => $course_id]);

        if ($result) {
            return new Course($stmt->fetch());
        }
    }

    public function getCourseByQueryParams($params)
    {
        $where_clause = "";
        $last_param = end($params);
        foreach ($params as $k => $v) {
            if ($v = $last_param) {
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

    public function save(Course $course) {
        $sql = "insert into courses
            (id, lang, \name, description, creator, date_created, date_updated) values
            (:id, :lang, :\name, :description, :date_created, :date_updated)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "id" => $course->getId(),
            "lang" => $course->getLang(),
            "name" => $course->getName(),
            "description" => $course->getDescription(),
            "creator" => $course->getCreator(),
            "date_created" => $course->getDateCreated(),
            "date_updated" => $course->getDateUpdated()
        ]);
        if(!$result) {
            throw new Exception("could not save course");
        }
    }
}