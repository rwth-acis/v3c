<?php

/**
 * Created by PhpStorm.
 * User: Rouchdi
 * Date: 12/7/2016
 * Time: 5:15 PM
 */
class course
{
    /*
    private $id;
    private $language;
    private $name;
    private $description;
    private $creator;
    private $points;
    private $units;
    */

    public function getCourses(){

        $conn = require '../php/db_connect.php';
        $sql_select = "SELECT * 
                        FROM users
                        INNER JOIN courses ON email = creator";

        $query = $conn->query($sql_select);
        $course = $query->fetch();

    }

    public function getUnits($course_id,$course_lang){

        $conn = require '../php/db_connect.php';
        $sql_select = "SELECT * 
                        FROM course_units
                        INNER JOIN course_to_unit ON id = unit_id AND lang = unit_lang
                        WHERE course_id = '$course_id' AND course_lang = '$course_lang'";

        $query = $conn->query($sql_select);
        $unit = $query->fetch();

        return $unit;

    }

}