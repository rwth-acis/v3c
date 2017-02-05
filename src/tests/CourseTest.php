<?php

require '../vendor/autoload.php';

class CourseTest extends PHPUnit_Framework_TestCase {

    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://v3c.dev/src/api/']);
    }

    public function testGetCourse()
    {
        $response = $this->client->request('GET', 'courses');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());
        for($i=0; $i<sizeof($data);$i++){
            $d = json_decode(json_encode($data[$i]),true);
            $this->assertArrayHasKey('id',$d);
            $this->assertArrayHasKey('lang',$d);
            $this->assertArrayHasKey('name',$d);
            $this->assertArrayHasKey('description',$d);
            $this->assertArrayHasKey('profession',$d);
            $this->assertArrayHasKey('creator',$d);
            $this->assertArrayHasKey('domain',$d);
            $this->assertArrayHasKey('date_created',$d);
            $this->assertArrayHasKey('date_updated',$d);
        }

    }

    public function testGetCoursebyId()
    {
        $id = rand(0,999);
        $response = $this->client->request('GET', "courses/$id");

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());
        for($i=0; $i<sizeof($data);$i++){
            $d = json_decode(json_encode($data[$i]),true);
            $this->assertArrayHasKey('id',$d);
            $this->assertArrayHasKey('lang',$d);
            $this->assertArrayHasKey('name',$d);
            $this->assertArrayHasKey('description',$d);
            $this->assertArrayHasKey('profession',$d);
            $this->assertArrayHasKey('creator',$d);
            $this->assertArrayHasKey('domain',$d);
            $this->assertArrayHasKey('date_created',$d);
            $this->assertArrayHasKey('date_updated',$d);
        }

    }

    public function testGetCourseby_Id_lang()
    {
        $id = rand(0,999);
        $lang = "it";

        $response = $this->client->request('GET', "courses/$id/$lang");

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());

        for($i=0; $i<sizeof($data);$i++){
            $d = json_decode(json_encode($data[$i]),true);
            $this->assertArrayHasKey('id',$d);
            $this->assertArrayHasKey('lang',$d);
            $this->assertArrayHasKey('name',$d);
            $this->assertArrayHasKey('description',$d);
            $this->assertArrayHasKey('profession',$d);
            $this->assertArrayHasKey('creator',$d);
            $this->assertArrayHasKey('domain',$d);
            $this->assertArrayHasKey('date_created',$d);
            $this->assertArrayHasKey('date_updated',$d);
        }
    }

    public function testPostCourse(){
        $response =$this->client->request('POST','courses',['json' =>[
            'name'=> 'Introduction to testing',
            'domain'=> '1',
            'profession'=> 'Tester',
            'description'=> 'testing API using test course',
            'language'=> 'en',
            'creator' => 'kpapavramidis@mastgroup.gr'
        ]]);

        $this->assertEquals(200,$response->getStatusCode());

    }

    public function tearDown() {
        $this->client = null;
    }

}
