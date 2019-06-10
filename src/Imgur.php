<?php
/**
 * Imgur class
 *
 * PHP version 7
 *
 * @category Imgur
 * @package  Imgur
 * @author   Linh Van <vanmylink@gmail.com>
 * @license  http://example.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/imgur/upload
 */
namespace Linhchan\Imgur;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

/**
 * Imgur class
 *
 * The class holding the root upload method
 *
 * @category Imgur
 * @package  Imgur
 * @author   Linh Van <vanmylink@gmail.com>
 * @license  http://example.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/imgur/upload
 */
class Imgur
{

    protected $url = 'https://api.imgur.com/3/image';

    protected $headers = [];

    protected $params = [];

    protected $size = [
        's',
        'b',
        't',
        'm',
        'l',
        'h',
    ];

    public $response;
    const VERSION = 'v3';

    private $_clientId;

    private $_clientSecret;

    private $_image;

    /**
     * Define _construct function.
     * 
     * @param string $_clientId     from Imgur account
     * @param string $_clientSecret from Imgur account
     */
    public function __construct($_clientId, $_clientSecret = null)
    {
        $this->_clientId     = $_clientId;
        $this->_clientSecret = $_clientSecret;
    } //end __construct()


    /**
     * Check API version.
     *
     * @return string
     */
    public static function version()
    {
        return self::VERSION;
    } //end version()


    /**
     * If concrete instance UploadedFile, it should transform base64, either return url.
     *
     * @param string $_image can be a link or upload file
     * 
     * @return string
     */
    public function fileType($_image)
    {
        if ($_image instanceof UploadedFile) {
            return base64_encode(file_get_contents($_image->path()));
        }

        return $_image;
    } //end fileType()


    /**
     * Set headers.
     *
     * @param string $headers headers of request
     * 
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    } //end setHeaders()

    /**
     * If does not set headers, using default header, either return headers.
     *
     * @return array
     */
    private function _getHeaders()
    {
        if (empty($this->headers)) {
            return [
                'headers' => [
                    'authorization' => 'Client-ID ' . $this->_clientId,
                    'content-type'  => 'application/x-www-form-urlencoded',
                ],
            ];
        }

        return $this->headers;
    } //end _getHeaders()


    /**
     * Set form params.
     *
     * @param string $params form
     * 
     * @return $this
     */
    public function setFormParams($params)
    {
        $this->params = $params;
        return $this;
    } //end setFormParams()


    /**
     * If does not set form, using default form, either return form.
     *
     * @return array
     */
    private function _getFormParams()
    {
        if (empty($this->params)) {
            return [
                'form_params' => [
                    'image' => $this->_image,
                ],
            ];
        }

        return $this->params;
    } //end _getFormParams()

    /**
     * Function set image
     * 
     * @param string $_image can be a link or upload file
     * 
     * @return array
     */
    private function _setImage($_image)
    {
        $this->_image = $_image;
        return $this;
    } //end _setImage()


    /**
     * Main entrance point.
     *
     * @param string $_image can be a link or upload file
     *
     * @return $this
     */
    public function upload($_image)
    {
        $client = new Client();
        $this->_setImage($this->fileType($_image));
        $response = $client->request('POST', $this->url, array_merge($this->_getHeaders(), $this->_getFormParams()));
        $this->_setResponse(json_decode($response->getBody()->getContents()));
        return $this;
    } //end upload()


    /**
     * Function get uploaded _image link.
     *
     * @return mixed
     */
    public function link()
    {
        return $this->response->data->link;
    } //end link()


    /**
     * Function get uploaded _image size.
     *
     * @return mixed
     */
    public function filesize()
    {
        return $this->response->data->size;
    } //end filesize()


    /**
     * Function get uploaded _image type.
     *
     * @return mixed
     */
    public function type()
    {
        return $this->response->data->type;
    } //end type()


    /**
     * Function get uploaded _image width.
     *
     * @return mixed
     */
    public function width()
    {
        return $this->response->data->width;
    } //end width()


    /**
     * Function get uploaded _image height.
     *
     * @return mixed
     */
    public function height()
    {
        return $this->response->data->height;
    } //end height()


    /**
     * Function get uploaded _image usual parameters.
     *
     * @return mixed
     */
    public function usual()
    {
        return [
            'link'     => $this->link(),
            'filesize' => $this->filesize(),
            'type'     => $this->type(),
            'width'    => $this->width(),
            'height'   => $this->height(),
        ];
    } //end usual()

    /**
     * Function set response.
     * 
     * @param string $response image
     *
     * @return $this
     */
    private function _setResponse($response)
    {
        $this->response = $response;
        return $this;
    } //end _setResponse()


    /**
     * Imgur _image size.
     *
     * @param string $url  url image
     * @param string $size size of image
     * 
     * @return string
     */
    public function size($url, $size)
    {
        if (!in_array($size, $this->size)) {
            throw new InvalidArgumentException("Imgur does not support ' $size ' type.");
        }

        $delimiter = 'https://i.imgur.com/';
        $_image     = explode('.', explode($delimiter, $url)[1]);
        return $delimiter . $_image[0] . $size . '.' . $_image[1];
    } //end size()


}//end class
