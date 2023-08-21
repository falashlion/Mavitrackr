<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\FeedbackRepository;
use App\Contracts\FeedbackRepositoryInterface;

class FeedbackRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(FeedbackRepositoryInterface::class, FeedbackRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
