Laravel - Imgur
=======

Note that this is a demo version

Installation
------------

```bash
composer require linhchan/imgur
```

```bash
Binding class using Facade in laravel
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
```

If you want to implement the interface, you can require this package and
implement `Linhchan\Imgur\Imgur` in your code.
