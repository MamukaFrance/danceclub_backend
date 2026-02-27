<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProfilRepositoryInterface;
use App\Repositories\EloquentProfilRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProfilRepositoryInterface::class, EloquentProfilRepository::class);
        // $this->app->bind(PostRepositoryInterface::class, EloquentPostRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
