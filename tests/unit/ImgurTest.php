<?php
namespace Linh\Imgur\Test\Unit;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Linhchan\Imgur\Http\Controllers\ImgurController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;

$app = new Application(); // Create a facade root, perhaps in setup()
$app->singleton('app', Application::class);
Facade::setFacadeApplication($app);

class ImgurTest extends TestCase
{
    private static $test_image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/1200px-Apple_logo_black.svg.png';
    private $object;
    private $controller;
    public function setUp():void
    {
        parent::setUp();
        $this->controller = new ImgurController("c4ac74e51e89984", null);
        $this->object = $this->controller->upload(static::$test_image);
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_see_version()
    {
        $expected = 'v3';
        $result = ImgurController::version();
        $this->assertEquals($expected, $result);
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_upload_image()
    {
        $this->assertInstanceOf(ImgurController::class, $this->controller);
        $this->assertEquals(200, $this->object->response->status);
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_get_link()
    {
        $this->assertEquals($this->object->response->data->link, $this->object->link());
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_get_size()
    {
        $this->assertEquals($this->object->response->data->size, $this->object->filesize());
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_get_type()
    {
        $this->assertEquals($this->object->response->data->type, $this->object->type());
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_get_width()
    {
        $this->assertEquals($this->object->response->data->width, $this->object->width());
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_get_height()
    {
        $this->assertEquals($this->object->response->data->height, $this->object->height());
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_get_usual()
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
     * @group ImgurController
     */
    public function it_should_get_exception_with_header()
    {
        $this->expectException(ClientException::class);
        $this->controller->setHeaders(['abc' => 'def'])->upload(self::$test_image);
    }
    /**
     * @test
     * @group ImgurController
     */
    public function it_should_get_exception_with_params()
    {
        $this->expectException(ClientException::class);
        $this->controller->setFormParams(['abc' => 'def'])->upload(self::$test_image);
    }
}