<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\EloquentUserRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(
            \App\Repositories\DepartmentRepository::class,
            \App\Repositories\EloquentDepartmentRepository::class
        );
        $this->app->bind(
            \App\Repositories\StrategicDomainRepository::class,
            \App\Repositories\EloquentStrategicDomainRepository::class
        );
        $this->app->bind(
            App\Repositories\EloquentFeedbackRepository::class,
            App\Repositories\FeedbackRepository::class
        );
        $this->app->bind(
            App\Repositories\EloquentKpaRepository::class,
            App\Repositories\KpaRepositoryInterface::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
