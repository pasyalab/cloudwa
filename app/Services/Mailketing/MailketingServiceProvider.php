<?php

namespace App\Services\Mailketing;

use App\Services\Mailketing\ApiClient;
use App\Services\Mailketing\MailketingTransport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;

class MailketingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Mail::extend('mailketing', function (array $config = []) {
            $client = new ApiClient($config);
            return new MailketingTransport($client);
        });
    }
}
