<?php
/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 11/01/2017
 * Time: 14:48
 */

spl_autoload_register(function ($classname) {
    require("../classes/" . $classname . ".php");
});

spl_autoload_register(function ($classname) {
    require("../classes/" . $classname . ".php");
});

function utf8_encode_object($object)
{
    $array_of_object = (array)$object;
    $object_class = get_class($object);
    $encoded_object = new $object_class($array_of_object);
    foreach ($encoded_object as $key => $value) {
        $encoded_object->$key = utf8_encode($value);
    }
    return $encoded_object;

}