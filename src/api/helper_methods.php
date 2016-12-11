<?php
/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 10/12/2016
 * Time: 16:06
 */

function containsQueryParam($url) {
    if (strpos($url, '?') !== false) {
        return true;
    } else {
        false;
    }
}

