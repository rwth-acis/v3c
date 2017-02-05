<?php

require '../vendor/autoload.php';

class SubjectTest extends PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://v3c.dev/src/api/']);
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
    
    public function tearDown() {
        $this->client = null;
    }

}