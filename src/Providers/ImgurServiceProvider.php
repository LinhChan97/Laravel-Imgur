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
        $this->app->bind(ImgurController::class, function ($app) {
            $client_id = $app['config']->get('imgur.client_id');
            $client_secret = $app['config']->get('imgur.client_secret');
            return new ImgurController($client_id, $client_secret);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require dirname(__DIR__, 1).'/Routes/web.php';
        $this->publishes([
            __DIR__ . '/../config/imgur.php' => config_path('imgur.php'),
        ], 'config');

    }
}
