<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\interfaces\DepartmentRepositoryInterface;
use App\interfaces\StrategicDomainRepositoryInterface;
use App\interfaces\FeedbackRepositoryInterface;
use App\interfaces\PositionRepositoryInterface;
use App\interfaces\KpaRepositoryInterface;
use App\interfaces\KpiRepositoryInterface;
use App\interfaces\UserRepositoryInterface;
use App\Repositories\FeedbackRepository;
use App\Repositories\KpiRepository;
use App\Repositories\KpiScoringRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\KpaRepository;
use App\Repositories\PositionRepository;
use App\Repositories\StrategicDomainRepository;
use App\Repositories\DepartmentRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class,DepartmentRepository::class);
        $this->app->bind(KpiRepositoryInterface::class,KpiRepository::class);
        $this->app->bind(KpiScoringRepositoryInterface::class,KpiScoringRepository::class);
        $this->app->bind(KpaRepositoryInterface::class,KpaRepository::class);
        $this->app->bind(FeedbackRepositoryInterface::class,FeedbackRepository::class);
        $this->app->bind(StrategicDomainRepositoryInterface::class,StrategicDomainRepository::class);
        $this->app->bind(FeedbackRepositoryInterface::class,FeedbackRepository::class);
        $this->app->bind(RoleRepositoryInterfaces::class,RoleRepository::class);
        $this->app->bind(PositionRepositoryInterface::class,PositionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
