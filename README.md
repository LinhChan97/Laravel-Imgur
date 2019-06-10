Laravel - Imgur 
=======
[![CircleCI](https://circleci.com/gh/LinhChan97/Laravel-Imgur.svg?style=svg)](https://circleci.com/gh/LinhChan97/Laravel-Imgur)
[![codecov.io](https://codecov.io/gh/linhchan97/laravel-imgur/branch/master/graphs/badge.svg?branch=master)](https://codecov.io/gh/LinhChan97/Laravel-Imgur/branch/master)
[![Latest Stable Version](https://poser.pugx.org/linhchan/imgur/v/stable)](https://packagist.org/packages/linhchan/imgur)
[![Total Downloads](https://poser.pugx.org/linhchan/imgur/downloads)](https://packagist.org/packages/linhchan/imgur)
[![License](https://poser.pugx.org/linhchan/imgur/license)](https://packagist.org/packages/linhchan/imgur)



Note that this is a demo version

Installation
------------

```bash
composer require linhchan/imgur
```

```bash
In config/app.php
Add service provider to your app.php [Providers]
Linhchan\Imgur\ImgurServiceProvider::class,

Binding class using Facade in laravel app.php [Aliases]
'Imgur' => Linhchan\Imgur\Facades\Imgur::class,
```

```bash
Publish config 
$ php artisan vendor:publish
```

```bash
Add your Imgur client id and client secret to you .env config
IMGUR_CLIENT_ID=
IMGUR_CLIENT_SECRET=
```


Usage
-----

If you need to upload an image and convert it to a link for storing or accessing easily

```php
use Linhchan\Imgur\Facades\Imgur;

class ImgurController extends Controller
{
    public function index()
    {
        //test Imgur Facade
        $uploadFile = 'https://www.w3schools.com/w3css/img_lights.jpg';
        $image = Imgur::upload($uploadFile);

        // Get imgur image link.
       $image->link(); //"https://i.imgur.com/XN9m1nW.jpg"

        // Get imgur image file type.
        $image->type(); //"image/jpeg"

        // Get imgur image width.
        $image->width(); //480

        // Get imgur image height.
        $image->height(); //640

        // Or you can get usual data.
        return $image->usual();

        //[
        //  'link' => "https://i.imgur.com/XN9m1nW.jpg",
        //  'filesize' => 43180,
        //  'type' => "image/jpeg",
        //  'width' => 480,
        //  'height' => 640,
        //]
    }
}

