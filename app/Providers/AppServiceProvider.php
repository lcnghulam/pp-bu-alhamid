<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\BackendLayout;
use App\View\Components\FrontendLayout;

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
        // <x-backend-layout>
        // backend-layout untuk mendeklarasikan <x-....>
        Blade::component('backend-layout', BackendLayout::class);
        Blade::component('frontend-layout', FrontendLayout::class);
    }
}
