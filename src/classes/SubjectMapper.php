<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 14/12/2016
 * Time: 17:27
 */
class SubjectMapper extends Mapper
{
    /**
     *
     * Get all the courses that match the query from database
     *
     * @param array $args
     * @return array
     */

    public function getSubjects($args = array())
    {
        $subjects_sql = "SELECT * FROM subjects";
        if (!empty($args)) {
            $where_clause = " WHERE ";
            $last_key = key(end($args));
            foreach ($args as $k => $v) {
                if (!is_numeric($v)) {
                    $v = "" . $v . "";
                }
                if ($k == $last_key) {
                    $where_clause .= " " . $k . " = " . $v;
                } else {
                    $where_clause .= " " . $k . " = " . $v . " AND ";
                }
            }

            $subjects_sql .= $where_clause;
        }

        $stmt = $this->db->query($subjects_sql);

        $subjects = [];

        while ($row = $stmt->fetch()) {

            $subjects[] = new Subject($row);
        }
        return $subjects;
    }
}