<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\EventParticipantRepositoryInterface::class,
            \App\Repositories\EloquentEventParticipantRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\EventRepositoryInterface::class,
            \App\Repositories\EloquentEventRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\PostRepositoryInterface::class,
            \App\Repositories\EloquentPostRepository::class
        );
        $this->app->bind(   
            \App\Repositories\Contracts\ProfilRepositoryInterface::class,
            \App\Repositories\EloquentProfilRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\CourseRepositoryInterface::class,
            \App\Repositories\EloquentCourseRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
