<?php

namespace Linhchan\Imgur;

use Illuminate\Support\ServiceProvider;
use Linhchan\Imgur\ImgurController;

class ImgurServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Imgur::class, function ($app) {
            $client_id = $app['config']->get('imgur.client_id');
            $client_secret = $app['config']->get('imgur.client_secret');
            return new Imgur($client_id, $client_secret);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__,2) . '/config/imgur.php' => config_path('imgur.php'),
        ], 'config');

    }
}
