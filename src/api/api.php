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

$protocol = (isset($_SERVER['HTTPS']) ? "https://" : "http://");
$baseUrl =  $protocol . $_SERVER['SERVER_NAME'];


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

$app->get('/courses/{id}', function (Request $request, Response $response, $args) {
    $course_id = (int)$args['id'];
    $course_mapper = new CourseMapper($this->db);
    $unit_mapper = new CourseUnitMapper($this->db);

    $courses = $course_mapper->getCoursesById($course_id);
    $courses_array = array();

    foreach ($courses as &$course) {
        $course = utf8_encode_object($course);
        $course_units = $unit_mapper->getCourseUnitsByIdAndLang($course->id, $course->lang);

        $encoded_course_units = utf8_encode_array($course_units);
        $course->course_units = $encoded_course_units;
        $courses_array[] = $course;

    }
    return $response->withJson($courses_array, null, JSON_PRETTY_PRINT);
});

/**
 *  Get a course by ID or update a course by ID
 */
$app->any('/courses/{id}/{lang}', function (Request $request, Response $response, $args) {
    $course_lang = $args['lang'];

    // Create course mapper for mapping the data between API and db
    $course_mapper = new CourseMapper($this->db);

    // GET
    if ($request->isGet()) {
        $course_id = (int)$args['id'];
        // Create course unit mapper for mapping data between API and db
        $unit_mapper = new CourseUnitMapper($this->db);

        // Get Courses and Course Units from db
        $courses = $course_mapper->getCourseByIdAndLang($course_id, $course_lang);

        $courses_array = array();
        // In the foreach, the course units are queried and then added to the course object
        foreach ($courses as &$course) {
            $course = utf8_encode_object($course);
            $course_units = $unit_mapper->getCourseUnitsByIdAndLang($course->id, $course_lang);

            $encoded_course_units = utf8_encode_array($course_units);
            $course->course_units = $encoded_course_units;
            $courses_array[] = $course;

            $courses_array = $course;

        }

        // Show response in JSON
        return $response->withJson($courses_array, null, JSON_PRETTY_PRINT);

        // PUT
    } else if ($request->isPut()) {
        // Get updated fields and pas them to course_mappers put-function
        $updated_fields = $request->getParsedBody();
        $updated_course = $course_mapper->put($updated_fields);
        $course_id = $updated_course['course_id'];
        $course_lang = $updated_course['course_lang'];

        // Redirect with status 302
        global $baseUrl;
        return $response->withStatus(302)->withHeader('Location',
            $baseUrl . "/src/views/editcourse.php?id=$course_id&lang=$course_lang");
        // POST
    }
});

// POST
$app->post('/courses', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $course_data = [];
    $course_data['creator'] = 'kpapavramidis@mastgroup.gr';
    $course_data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $course_data['domain'] = filter_var($data['domain'], FILTER_SANITIZE_STRING);
    $course_data['profession'] = filter_var($data['profession'], FILTER_SANITIZE_STRING);
    $course_data['description'] = filter_var($data['description'], FILTER_SANITIZE_STRING);
    $course_data['lang'] = filter_var($data['language'], FILTER_SANITIZE_STRING);
    $course_data['date_created'] = date('Y/m/d h:i:s', time());
    $course_data['date_updated'] = date('Y/m/d h:i:s', time());
    $course_mapper = new CourseMapper($this->db);

    $course = new Course($course_data);
    $inserted_course = $course_mapper->save($course);
    $course_id = $inserted_course["course_id"];
    $course_lang = $inserted_course["course_lang"];

    // After creating a course, the user is redirected to the edit page. The reason
    // for this is, that it is not possible to add models on addcourse.php. But the user
    // can add models on editcourse.php

    global $baseUrl;

    return $response->withStatus(302)->withHeader('Location',
        $baseUrl . "/src/views/editcourse.php?id=$course_id&lang=$course_lang");
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


$app->get('/courses/{id}/{lang}/units', function (Request $request, Response $response, $args) {
    $course_id = (int)$args['id'];
    $course_lang = $args['lang'];

    $unit_mapper = new CourseUnitMapper($this->db);
    $course_units = $unit_mapper->getCourseUnitsByIdAndLang($course_id, $course_lang);

    $encoded_course_units = utf8_encode_array($course_units);

    // Show response in JSON
    return $response->withJson($encoded_course_units, null, JSON_PRETTY_PRINT);
});

$app->post('/courses/{id}/{lang}/units', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $course_id = (int)$args['id'];
    $course_lang = $args['lang'];

    $unit_mapper = new CourseUnitMapper($this->db);
    $course_unit_data = [];

    // Get input data from form
    $course_id = filter_var($data["courseid"], FILTER_SANITIZE_NUMBER_INT);
    $course_lang = filter_var($data["courselang"], FILTER_SANITIZE_STRING);

    $course_unit_data["lang"] = $course_lang;
    $course_unit_data['title'] = filter_var($data["name"], FILTER_SANITIZE_STRING);
    $course_unit_data['points'] = filter_var($data["points"], FILTER_SANITIZE_STRING);
    $course_unit_data['start_date'] = filter_var($data["startdate"], FILTER_SANITIZE_STRING);
    $course_data['date_created'] = date('Y/m/d h:i:s', time());
    $course_unit_data['description'] = filter_var($data["description"], FILTER_SANITIZE_STRING);

    $course_unit = new CourseUnit($course_unit_data);
    $unit_mapper->save($course_id, $course_lang, $course_unit);

    // After creating a course, the user is redirected to the edit page. The reason
    // for this is, that it is not possible to add models on addcourse.php. But the user
    // can add models on editcourse.php
    global $baseUrl;
    return $response->withStatus(302)->withHeader('Location',
        $baseUrl . "/src/views/editcourse.php?id=$course_id&lang=$course_lang");
});
$app->run();
?>