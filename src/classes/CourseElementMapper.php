<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 10/12/2016
 * Time: 01:32
 */
class CourseElementMapper extends Mapper
{
    public function getCourseElements() {
        $course_elements_sql = "SELECT * FROM course_elements";
        $stmt = $this->db->query($course_elements_sql);

        $course_elements = [];

        while($row = $stmt->fetch()) {
            $course_elements[] = new CourseElement($row);
        }
        return $course_elements;

    }
}