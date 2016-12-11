<?php
/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 08/12/2016
 * Time: 13:07
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

include '../php/db_connect.php';
include '../config/config.php';
require '../vendor/autoload.php';
require_once '../api/helper_methods.php';

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

$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};


$container['logger'] = function($c) {
    // Create the logger
    $logger = new \Monolog\Logger('my_logger');
    // Now add some handlers
    $logger->pushHandler(new StreamHandler(__DIR__.'/my_app.log', Logger::DEBUG));
    $logger->pushHandler(new FirePHPHandler());

    // You can now use your logger
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
$app->get('/courses', function (Request $request, Response $response) {
    $mapper = new CourseMapper($this->db);
    $courses = $mapper->getCourses($request->getQueryParams());
    $this->logger->addInfo("array: ", $request->getQueryParams());
    $courses_array = array();
    foreach ($courses as $course) {
        $courses_array[] = (array)$course;
    }
    $response = $response->withJson($courses_array);
    return $response;
});

/**
 * Get Course
 */
$app->get('/courses/{id}', function (Request $request, Response $response, $args) {
    $course_id = (int)$args['id'];
    $mapper = new CourseMapper($this->db);
    $course = $mapper->getCourseById($course_id);
    $course = (array)$course;
    $response = $response->withJson($course, null, JSON_UNESCAPED_UNICODE);
    return $response;
});

/**
 * Get Course Units
 */
$app->get('/courses/{id}/course_units', function (Request $request, Response $response, $args) use ($app) {
    $course_id = (int)$args['id'];
    $this->logger->addInfo("course id : " . $course_id);
    $mapper = new CourseUnitMapper($this->db);
    $course_elements = $mapper->getCourseUnits($course_id);
    $course_units_array = array();
    foreach ($course_elements as $course_unit) {
        $course_units_array[] = (array)$course_unit;
    }
    $new_response = $response->withJson($course_units_array);

    return $new_response;
});

/**
 * Get Course Unit
 */
$app->get('/courses/{course_id}/course_units/{unit_id}', function (Request $request, Response $response, $args) use ($app) {
    $course_id = (int)$args['course_id'];
    $course_unit_id = (int)$args['unit_id'];
    $mapper = new CourseUnitMapper($this->db);
    $course_unit = $mapper->getCourseUnitById($course_id, $course_unit_id);
    $course_unit = (array)$course_unit;
    $new_response = $response->withJson($course_unit);

    return $new_response;
});

/**
 * Get Course Elements

$app->get('/courses/{id}/course_elements', function (Request $request, Response $response) use ($app) {
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
 */




$app->run();
?>