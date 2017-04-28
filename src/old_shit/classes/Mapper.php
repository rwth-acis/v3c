<?php

/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 09/12/2016
 * Time: 23:36
 *
 * Mappers are used to query the data from db. This is an abstract clas
 */
Abstract class Mapper
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}