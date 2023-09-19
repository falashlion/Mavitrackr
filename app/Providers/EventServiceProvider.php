<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        Department::updated(function ($department) {
            $users = User::where('departments_id', $department->id)->get();

            foreach ($users as $user) {
                if ($user->line_manager === $department->manager_id) {
                    $user->line_manager = $department->new_manager_id;
                    $user->save();
                }
            }
        });
        User::deleted(function ($user) {
            $users = User::where('departments_id', $user->id)->get();

            foreach ($users as $user) {
                if ($user->line_manager === $user->manager_id) {
                    $user->line_manager = $user->manager_id;
                    $user->save();
                }
            }
        });

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
