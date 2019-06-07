<?php
namespace Linhchan\Imgur\Facades;

use Illuminate\Support\Facades\Facade;

class Imgur extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Linhchan\Imgur\ImgurController::class;
    }
}
