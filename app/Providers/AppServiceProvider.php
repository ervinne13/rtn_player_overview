<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // TODO: Since defaultView does the binds itself, we can't do contextual binding
        // Tech Debt: we check how can we conditionally set which pagination to use
        // Paginator::defaultView('vendor.pagination.default');
        // $this->app->when(Firewall::class)
        //   ->needs(Paginator::class)
        //   ->give(function() {
        //     return Paginator::defaultView('player-overview.pagination');
        //   });        
    }
}
