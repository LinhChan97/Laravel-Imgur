<?php
namespace Linhchan\Imgur\Facades;

use Illuminate\Support\Facades\Facade;

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
