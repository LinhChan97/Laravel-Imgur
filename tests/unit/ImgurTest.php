<?php
namespace Linh\Imgur\Test\Unit;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Linhchan\Imgur\Imgur;
use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Illuminate\Support\Facades\Facade;

/**
 * Class test Imgur class
 * 
 * @category Library
 * @package  Imgur
 * @author   linhchan <vanmylink@gmail.com>
 */
class ImgurTest extends TestCase
{
    private static $test_image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/1200px-Apple_logo_black.svg.png';
    private  $local_file = __DIR__ . '/test.jpg';
    private $object;
    private $controller;
    public function setUp(): void
    {
        parent::setUp();
        $this->initial();
        $this->controller = new Imgur("c4ac74e51e89984", null);
        $this->object = $this->controller->upload(static::$test_image);
    }
    public function initial()
    {
        $app = new Application(); // Create a facade root, perhaps in setup()
        $app->singleton('app', Application::class);
        Facade::setFacadeApplication($app);
    }
    /**
     * @test
     * @group Imgur
     */
    public function testUploadFileLocalSuccess()
    {
        $file = new \Illuminate\Http\UploadedFile($this->local_file, 'test.jpg', null, null, null, true);
        $expected = base64_encode(file_get_contents($file->path()));
        $result = $this->controller->fileType($file);
        $this->assertEquals($expected, $result);
    }
    /**
     * @test
     * @group imgur
     */
    public function testGetSpecificFileSize()
    {
        $origin = "https://i.imgur.com/BO49tuZ.jpg";
        $result = $this->controller->size($origin, 's');
        $this->assertEquals("https://i.imgur.com/BO49tuZs.jpg", $result);
    }
    /**
     * @test
     * @group imgur
     */
    public function testGetExceptionWithWrongSize()
    {

        $this->expectException(InvalidArgumentException::class);
        $origin = "https://i.imgur.com/BO49tuZ.jpg";
        $result = $this->controller->size($origin, 'hh');
    }
    /**
     * @test
     * @group Imgur
     */
    public function testSeeVersionSuccess()
    {
        $expected = 'v3';
        $result = Imgur::version();
        $this->assertEquals($expected, $result);
    }
    /**
     * @test
     * @group Imgur
     */
    public function testUploadFileSuccess()
    {
        $this->assertInstanceOf(Imgur::class,  $this->controller->upload(static::$test_image));
        $this->assertEquals(200, $this->object->response->status);
    }
    /**
     * @test
     * @group imgur
     */
    public function testSetUpRequestInfoSuccess()
    {
        putenv('IMGUR_CLIENT_ID=c4ac74e51e89984');
        $result = $this->controller->setHeaders([
            'headers' => [
                'authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
                'content-type' => 'application/x-www-form-urlencoded',
            ]
        ])->setFormParams([
            'form_params' => [
                'image' => self::$test_image,
            ]
        ])->upload(self::$test_image);
        $this->assertEquals(200, $result->response->status);
    }
    /**
     * @test
     * @group Imgur
     */
    public function testUploadImageSuccess()
    {
        $this->assertInstanceOf(Imgur::class, $this->controller);
        $this->assertEquals(200, $this->object->response->status);
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetLinkSuccess()
    {
        $this->assertEquals($this->object->response->data->link, $this->object->link());
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetSizeSuccess()
    {
        $this->assertEquals($this->object->response->data->size, $this->object->filesize());
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetTypeSuccess()
    {
        $this->assertEquals($this->object->response->data->type, $this->object->type());
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetWidthSuccess()
    {
        $this->assertEquals($this->object->response->data->width, $this->object->width());
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetHeightSuccess()
    {
        $this->assertEquals($this->object->response->data->height, $this->object->height());
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetUsualSucceess()
    {
        $this->assertEquals([
            'link' => $this->object->response->data->link,
            'filesize' => $this->object->response->data->size,
            'type' => $this->object->response->data->type,
            'width' => $this->object->response->data->width,
            'height' => $this->object->response->data->height,
        ], $this->object->usual());
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetExceptionWithHeader()
    {
        $this->expectException(ClientException::class);
        $this->controller->setHeaders(['abc' => 'def'])->upload(self::$test_image);
    }
    /**
     * @test
     * @group Imgur
     */
    public function testGetExceptionWithParam()
    {
        $this->expectException(ClientException::class);
        $this->controller->setFormParams(['abc' => 'def'])->upload(self::$test_image);
    }
}
