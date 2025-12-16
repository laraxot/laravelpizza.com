<?php

declare(strict_types=1);

namespace Themes\Meetup\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'pub_theme');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'meetup');
    }
}
