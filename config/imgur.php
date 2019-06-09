<?php
namespace Linhchan\Imgur\Config;

/**
 * Imgur Config class
 *
 * @category Imgur
 * @package  Imgur
 * @author   Linh Van <vanmylink@gmail.com>
 * @license  http://example.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/imgur/upload
 */

return [
    /**
     * Set Imgur application client_id and secret key.
     */

    'client_id' => env('IMGUR_CLIENT_ID'),
    'client_secret' => env('IMGUR_CLIENT_SECRET', null),
];
