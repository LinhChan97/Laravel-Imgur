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

namespace Linhchan\Imgur\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Imgur Facade
 *
 * The facade class
 *
 * @category Imgur
 * @package  Imgur
 * @author   Linh Van <vanmylink@gmail.com>
 * @license  http://example.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/imgur/upload
 */
class Imgur extends Facade
{


    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Linhchan\Imgur\Imgur::class;

    }//end getFacadeAccessor()


}//end class
