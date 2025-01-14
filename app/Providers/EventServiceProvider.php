<?php

namespace App\Providers;

use App\Listeners\UpdateLineManagerId;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Events\Updating;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use App\Models\Department;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        Registered::class => [
            SetLineManagerId::class,
        ],
        Updating::class => [
            UpdateLineManagerId::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {


    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
