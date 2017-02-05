<?php

require '../vendor/autoload.php';

class CourseUnitsTest extends PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://v3c.dev/src/api/']);
    }

    public function testGetCourseUnits()
    {
        $id = 1;
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


    public function testPostCourseUnits(){

        $date = date('Y-m-d');

        $response =$this->client->request('POST',"courses/1/en/units",['json' =>[
            'courseid'=>'1',
            'courselang'=> 'en',
            'name'=> 'Test course unit',
            'points'=> '12',
            'startdate'=> "$date",
            'description'=> 'this is a description for test course unit',
        ]]);

        $this->assertEquals(200,$response->getStatusCode());

    }

    public function tearDown() {
        $this->client = null;
    }

}