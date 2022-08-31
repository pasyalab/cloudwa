<?php

namespace App\Services\OneSender;

use App\Services\OneSender\OneSender;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\ChannelManager;

class OneSenderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OneSender::class, function ($app) {
            return new OneSender(config('webapp.whatsapp_api_url'), config('webapp.whatsapp_api_key'));
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('onesender', function ($app) {
                return $app->get(OneSender::class);
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
