<?php

namespace App\Providers;

use App\Repositories\EloquentFeedbackRepository;
use App\Repositories\EloquentKpiRepository;
use App\Repositories\EloquentKpiScoringRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\EloquentKpaRepository;
use App\Repositories\EloquentRoleRepository;

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
            \App\Repositories\KpiRepository::class, EloquentKpiRepository::class
        );
        $this->app->bind(
            \App\Repositories\KpiScoringRepository::class, EloquentKpiScoringRepository::class
        );
        $this->app->bind(
            \App\Repositories\KpaRepository::class, EloquentKpaRepository::class
        );
        $this->app->bind(
            \App\Repositories\FeedbackRepository::class, EloquentFeedbackRepository::class
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
            \App\Repositories\RoleRepository::class, EloquentRoleRepository::class
        );
        $this->app->bind(
            App\Repositories\PositionRepository::class,
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
