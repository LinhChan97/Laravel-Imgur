<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;

$app = new Application(); // Create a facade root, perhaps in setup()
$app->singleton('app', Application::class);
Facade::setFacadeApplication($app);

class ImgurRouteTest extends TestCase
{
    private static $test_image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/1200px-Apple_logo_black.svg.png';
    protected $client;
    
    protected function setUp():void
    {
        $this->client = new Client([
            'base_uri' => '127.0.0.1'
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testUploadSuccessTest()
    // {
    //     $response = $this->call('POST', $this->urlApi,  [
    //             'json' => [
    //                 'image' => static::$test_image
    //             ]
    //         ]
    //     );

    //     $this->assertEquals(200, $response->getStatusCode());
    
    // }
}