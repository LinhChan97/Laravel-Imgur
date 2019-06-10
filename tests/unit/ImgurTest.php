<?php
/**
 * Test Doc
 *
 * PHP version 7
 *
 * @category Imgur
 * @package  Imgur
 * @author   Linhchan <vanmylink@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     Http://www.wordpressleaf.com
 */
namespace Linh\Imgur\Test\Unit;


use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Linhchan\Imgur\Imgur;
use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Illuminate\Support\Facades\Facade;
/**
 * Imgur class
 *
 * @category Library
 * @package  Imgur
 * @author   linhchan <vanmylink@gmail.com>
 * @license  example.com MIT license
 * @link     example.com
 */
class ImgurTest extends TestCase
{

    private static $_testImage = 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/1200px-Apple_logo_black.svg.png';

    private $_localFile = __DIR__.'/test.jpg';

    private $_object;

    private $_controller;


    /**
     * Override function setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->initial();
        $this->_controller = new Imgur('c4ac74e51e89984', null);
        $this->_object     = $this->_controller->upload(static::$_testImage);

    }//end setUp()


    /**
     * Function initial()
     *
     * @return void
     */
    public function initial()
    {
        $app = new Application();
        // Create a facade root, perhaps in setup()
        $app->singleton('app', Application::class);
        Facade::setFacadeApplication($app);

    }//end initial()


    /**
     * Function test Upload File Local Succcess
     *
     * @test
     * @group  Imgur
     * @return Assert Equal file
     */
    public function testUploadFileLocalSuccess()
    {
        $file     = new \Illuminate\Http\UploadedFile($this->_localFile, 'test.jpg', null, null, null, true);
        $expected = base64_encode(file_get_contents($file->path()));
        $result   = $this->_controller->fileType($file);
        $this->assertEquals($expected, $result);

    }//end testUploadFileLocalSuccess()


    /**
     * Function test get specific file size
     *
     * @test
     * @group  imgur
     * @return Assert Equal link
     */
    public function testGetSpecificFileSize()
    {
        $origin = 'https://i.imgur.com/BO49tuZ.jpg';
        $result = $this->_controller->size($origin, 's');
        $this->assertEquals('https://i.imgur.com/BO49tuZs.jpg', $result);

    }//end testGetSpecificFileSize()


    /**
     * Function test get exception with the wrong size
     *
     * @test
     * @group  imgur
     * @return Exception InvalidArgumentException
     */
    public function testGetExceptionWithWrongSize()
    {
        $this->expectException(InvalidArgumentException::class);
        $origin = 'https://i.imgur.com/BO49tuZ.jpg';
        $result = $this->_controller->size($origin, 'hh');

    }//end testGetExceptionWithWrongSize()


    /**
     * Function test see version success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal version
     */
    public function testSeeVersionSuccess()
    {
        $expected = 'v3';
        $result   = Imgur::version();
        $this->assertEquals($expected, $result);

    }//end testSeeVersionSuccess()


    /**
     * Function test upload file success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal status
     */
    public function testUploadFileSuccess()
    {
        $this->assertInstanceOf(Imgur::class, $this->_controller->upload(static::$_testImage));
        $this->assertEquals(200, $this->_object->response->status);

    }//end testUploadFileSuccess()


    /**
     * Function test set up request information success
     *
     * @test
     * @group  imgur
     * @return Assert Equal status
     */
    public function testSetUpRequestInfoSuccess()
    {
        putenv('IMGUR_CLIENT_ID=c4ac74e51e89984');
        $result = $this->_controller->setHeaders(
            [
                'headers' => [
                    'authorization' => 'Client-ID '.env('IMGUR_CLIENT_ID'),
                    'content-type'  => 'application/x-www-form-urlencoded',
                ],
            ]
        )->setFormParams(
            [
                'form_params' => [
                    'image' => self::$_testImage,
                ],
            ]
        )->upload(self::$_testImage);
        $this->assertEquals(200, $result->response->status);

    }//end testSetUpRequestInfoSuccess()


    /**
     * Function test upload image success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal status
     */
    public function testUploadImageSuccess()
    {
        $this->assertInstanceOf(Imgur::class, $this->_controller);
        $this->assertEquals(200, $this->_object->response->status);

    }//end testUploadImageSuccess()


    /**
     * Function test get link success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal link
     */
    public function testGetLinkSuccess()
    {
        $this->assertEquals($this->_object->response->data->link, $this->_object->link());

    }//end testGetLinkSuccess()


    /**
     * Function test get size success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal filesize
     */
    public function testGetSizeSuccess()
    {
        $this->assertEquals($this->_object->response->data->size, $this->_object->filesize());

    }//end testGetSizeSuccess()


    /**
     * Function test get file type success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal type
     */
    public function testGetTypeSuccess()
    {
        $this->assertEquals($this->_object->response->data->type, $this->_object->type());

    }//end testGetTypeSuccess()


    /**
     * Function test get width success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal width
     */
    public function testGetWidthSuccess()
    {
        $this->assertEquals($this->_object->response->data->width, $this->_object->width());

    }//end testGetWidthSuccess()


    /**
     * Function test get height success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal height
     */
    public function testGetHeightSuccess()
    {
        $this->assertEquals($this->_object->response->data->height, $this->_object->height());

    }//end testGetHeightSuccess()


    /**
     * Function test get usual success
     *
     * @test
     * @group  Imgur
     * @return Assert Equal usual information
     */
    public function testGetUsualSuccess()
    {
        $this->assertEquals(
            [
                'link'     => $this->_object->response->data->link,
                'filesize' => $this->_object->response->data->size,
                'type'     => $this->_object->response->data->type,
                'width'    => $this->_object->response->data->width,
                'height'   => $this->_object->response->data->height,
            ],
            $this->_object->usual()
        );

    }//end testGetUsualSuccess()


    /**
     * Function test get exception with header
     *
     * @test
     * @group  Imgur
     * @return Assert Exception ClientException
     */
    public function testGetExceptionWithHeader()
    {
        $this->expectException(ClientException::class);
        $this->_controller->setHeaders(['abc' => 'def'])->upload(self::$_testImage);

    }//end testGetExceptionWithHeader()


    /**
     * Function test get exception with param
     *
     * @test
     * @group  Imgur
     * @return Assert Exception ClientException
     */
    public function testGetExceptionWithParam()
    {
        $this->expectException(ClientException::class);
        $this->_controller->setFormParams(['abc' => 'def'])->upload(self::$_testImage);

    }//end testGetExceptionWithParam()


}//end class
