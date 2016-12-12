<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 10/12/2016
 * Time: 01:32
 */
class CourseElementMapper extends Mapper
{
    public function getCourseElements($course_id, $course_unit_id) {
        $course_elements_sql = "SELECT * FROM course_elements JOIN unit_to_element AS ute ON ute.course_id =";
        $stmt = $this->db->query($course_elements_sql);

        $course_elements = [];

        while($row = $stmt->fetch()) {
            $course_elements[] = new CourseElement($row);
        }
        return $course_elements;

    }
}