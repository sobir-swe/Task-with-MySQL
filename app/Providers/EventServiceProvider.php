<?php

namespace App\Providers;

use App\Service\SessionAccount;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\SomeListener',
        ],
    ];

    public function register(): void
    {
        //
    }


    public function boot(): void
    {

    }

}
