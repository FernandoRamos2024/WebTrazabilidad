<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use App\View\Components\DataCards;
use App\View\Components\SearchLatest;
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
        Blade::component('data-cards-component', DataCards::class);
        Blade::component('search-latest-component', SearchLatest::class);
    }
}
