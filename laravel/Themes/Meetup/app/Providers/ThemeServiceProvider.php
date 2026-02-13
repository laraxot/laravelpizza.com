<?php

declare(strict_types=1);

namespace Themes\Meetup\Providers;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'pub_theme');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'pub_theme');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'meetup');
    }
}
