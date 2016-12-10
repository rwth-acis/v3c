<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 09/12/2016
 * Time: 23:37
 */
class CourseMapper extends Mapper
{
    public function getCourses() {
        $courses_sql = "SELECT * FROM courses";
        $stmt = $this->db->query($courses_sql);

        $courses = [];

        while($row = $stmt->fetch()) {
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
    public function getCourseById($course_id) {
        $course_by_id_sql = "SELECT * FROM courses WHERE id = :course_id";
        $stmt = $this->db->prepare($course_by_id_sql);
        $result = $stmt->execute(["course_id" => $course_id]);

        if($result) {
            return new Course($stmt->fetch());
        }
    }
}