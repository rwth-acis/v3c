<?php
/**
 * Created by PhpStorm.
 * User: laurieuren
 * Date: 08/12/2016
 * Time: 13:07
 *
 *  This is the VIRTUS API
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

include '../php/db_connect.php';
include '../config/config.php';
require '../vendor/autoload.php';

spl_autoload_register(function ($classname) {
    require("../classes/" . $classname . ".php");
});

spl_autoload_register(function ($classname) {
    require("../classes/" . $classname . ".php");
});

// The $config array is set up with the database credentials
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host'] = $host;
$config['db']['user'] = $user;
$config['db']['pass'] = $password;
$config['db']['dbname'] = $database;

// The application is created
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


$container['logger'] = function ($c) {
    // Create the logger
    $logger = new \Monolog\Logger('my_logger');
    // Now add some handlers
    $logger->pushHandler(new StreamHandler(__DIR__ . '/my_app.log', Logger::DEBUG));
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
 * Get all courses and included course units
 */
$app->get('/courses', function (Request $request, Response $response) {
    $mapper = new CourseMapper($this->db);
    $unit_mapper = new CourseUnitMapper($this->db);
    $courses = $mapper->getCourses($request->getQueryParams());
    $courses_array = array();
    // In the foreach, the course units are queried and then added to the course object
    foreach ($courses as $course) {
        $courses_array[] = $course;
        $course_units = $unit_mapper->getCourseUnits($course->id);
        $course->course_units = $course_units;
    }
    $response = $response->withJson($courses_array, null, JSON_PRETTY_PRINT);
    return $response;
});

/**
 * Get a particular course with an id
 */
$app->get('/courses/{id}', function (Request $request, Response $response, $args) {
    $course_id = (int)$args['id'];
    $course_mapper = new CourseMapper($this->db);
    $unit_mapper = new CourseUnitMapper($this->db);
    $course = $course_mapper->getCourseById($course_id);
    $course_units = $unit_mapper->getCourseUnits($course_id);

    $course->course_units = $course_units;
    $response = $response->withJson($course, null, JSON_PRETTY_PRINT);
    return $response;
});

/**
 * Get all subjects
 */
$app->get('/subjects', function (Request $request, Response $response, $args) {
    $subject_mapper = new SubjectMapper($this->db);
    $subjects = $subject_mapper->getSubjects($request->getQueryParams());

    $new_response = $response->withJson($subjects, null, JSON_PRETTY_PRINT);
    return $new_response;
});

$app->run();
?>