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
include_once '../classes/helper_methods.php';
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

$app->get('/courses', function (Request $request, Response $response) {
    $mapper = new CourseMapper($this->db);
    $unit_mapper = new CourseUnitMapper($this->db);
    $courses = $mapper->getCourses($request->getQueryParams());
    $courses_array = array();
    // In the foreach, the course units are queried and then added to the course object
    foreach ($courses as &$course) {
        $course = utf8_encode_object($course);

        $course_units = $unit_mapper->getCourseUnits($course->id);
        $encoded_course_units = array();
        foreach ($course_units as $unit) {
            $encoded_course_units[] = utf8_encode_object($unit);
        }
        $course->course_units = $encoded_course_units;
        $courses_array[] = $course;
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
    foreach ($subjects as &$subject) {
        $subject = utf8_encode_object($subject);
    }
    $new_response = $response->withJson($subjects, null, JSON_PRETTY_PRINT);
    return $new_response;
});

// POST

$app->post('/courses/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $course_data = [];
    $course_data['name'] = filter_var($data['targetName'], FILTER_SANITIZE_STRING);
    $course_data['domain'] = filter_var($data['targetDomain'], FILTER_SANITIZE_STRING);
    $course_data['profession'] = filter_var($data['targetProfession'], FILTER_SANITIZE_STRING);
    $course_data['desription'] = filter_var($data['targetDescription'], FILTER_SANITIZE_STRING);
    $course_data['lang'] = "en"; //TODO Add language implementation from the form when the creation form is decided
    $course_data['date_created'] = date('Y/m/d h:i:s', time());
    $course_data['date_updated'] = date('Y/m/d h:i:s', time());
    $course_mapper = new CourseMapper($this->db);

    $course = new Course($course_data);
    $course_mapper->save($course);
    $response = $response->withRedirect("/courses");

    return $response;
});



$app->run();
?>