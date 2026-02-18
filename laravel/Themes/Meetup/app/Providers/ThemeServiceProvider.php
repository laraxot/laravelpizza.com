<?php

declare(strict_types=1);

namespace Themes\Meetup\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Themes\Meetup\Http\Controllers\EventBookingController;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'pub_theme');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'pub_theme');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'meetup');

        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        Route::post('/events/{slug}/book', [EventBookingController::class, 'book'])
            ->name('events.book');
    }
}
