<?php

class CourseTest extends PHPUnit_Framework_TestCase {

    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://v3c.dev/src/api/api.php']);
    }

    public function testGetSubjects(){
        $response = $this->client->request('GET', 'subjects');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());
        for($i=0; $i<sizeof($data);$i++){
            $d = json_decode(json_encode($data[$i]),true);
            $this->assertArrayHasKey('id',$d);
            $this->assertArrayHasKey('name',$d);
            $this->assertArrayHasKey('img_url',$d);
            $this->assertArrayHasKey('created_at',$d);
            $this->assertArrayHasKey('updated_at',$d);
            $this->assertArrayHasKey('date_updated',$d);
        }

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

    public function testGetCourseUnits()
    {
        $id = rand(0,999);
        $lang = "en";

        $response = $this->client->request('GET', "courses/$id/$lang/units");

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody());
        for($i=0; $i<sizeof($data);$i++){
            $d = json_decode(json_encode($data[$i]),true);
            $this->assertArrayHasKey('id',$d);
            $this->assertArrayHasKey('lang',$d);
            $this->assertArrayHasKey('title',$d);
            $this->assertArrayHasKey('description',$d);
            $this->assertArrayHasKey('start_date',$d);
            $this->assertArrayHasKey('points',$d);
            $this->assertArrayHasKey('date_created',$d);
            $this->assertArrayHasKey('date_updated',$d);
        }
    }

    public function testPostCourse(){
        //$id = rand(0,999);
        $response =$this->client->request('POST','courses',[
            'creator' =>'kpapavramidis@mastgroup.gr',
            'name'=> 'Test course',
            'domain'=> '1',
            'profession'=> 'Course Tester',
            'description'=> 'This course is used for testing ',
            'lang'=> 'en',
        ]);

        $this->assertEquals(200,$response->getStatusCode());
        $data = json_decode($response->getBody());
        var_dump($data);
    }

    public function tearDown() {
        $this->client = null;
    }

}
