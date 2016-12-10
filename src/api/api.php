<?php
/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 08/12/2016
 * Time: 13:07
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

include '../php/db_connect.php';
include '../config/config.php';
require '../vendor/autoload.php';

spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});

spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = $host;
$config['db']['user']   = $user;
$config['db']['pass']   = $password;
$config['db']['dbname'] = $database;

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("../api_templates/");


$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/', function (Request $request, Response $response) {
    $response = "Welcome to the VIRTUS API";
    return $response;
});

/**
 * Get Courses
 */
$app->get('/courses', function (Request $request, Response $response) use ($app) {
    $mapper = new CourseMapper($this->db);
    $courses = $mapper->getCourses();
    $courses_array = array();
    foreach ($courses as $course) {
        $courses_array[] = (array)$course;
    }
    $new_response = $response->withJson($courses_array);

    //$response = $this->view->render($response, "courses.phtml", ["courses" => $courses, "router" => $this->router] );
    return $new_response;
});

/**
 * Get Course
 */
$app->get('/courses/{id}', function (Request $request, Response $response, $args) {
    $q = $request->getQueryParams();
    $course_id = (int)$args['id'];
    $mapper = new CourseMapper($this->db);
    $course = $mapper->getCourseById($course_id);
    $course = (array)$course;
    $response = $response->withJson($course, null, JSON_UNESCAPED_UNICODE);
    return $response;
});


/**
 * Get Course Elements
 */
$app->get('/course_elements', function (Request $request, Response $response) use ($app) {
    $mapper = new CourseElementMapper($this->db);
    $course_elements = $mapper->getCourseElements();
    $course_el_array = array();
    foreach ($course_elements as $course_el) {
        $course_elements_array[] = (array)$course_el;
    }
    $new_response = $response->withJson($course_el_array);

    //$response = $this->view->render($response, "courses.phtml", ["courses" => $courses, "router" => $this->router] );
    return $new_response;
});



$app->run();
?>