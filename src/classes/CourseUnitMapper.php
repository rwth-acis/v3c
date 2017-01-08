<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 11/12/2016
 * Time: 12:54
 */
class CourseUnitMapper extends Mapper
{
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
}