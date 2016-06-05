<?php

namespace App\Test\TestCase\Api;
use GuzzleHttp\Client;

class GamesControllerTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://cakeapi.dev',
            'timeout'  => 2.0,
        ]);
    }

    public function testEdit_WithCover_ReturnsSuccess()
    {
        $file = file_get_contents(__DIR__.'/bf4.png');
        $response = $this->client->request('PATCH', '/games/2', [
            'http_errors' => false,
            'json' => ['cover' => base64_encode($file)]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
