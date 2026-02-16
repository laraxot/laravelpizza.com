<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class FolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Get the active theme from configuration
        $theme = config('xra.pub_theme', 'Meetup');

        // Try theme's pages directory first, fallback to default
        $themePagesPath = base_path("laravel/Themes/{$theme}/resources/views/pages");
        $defaultPagesPath = resource_path('views/pages');

        $pagesPath = is_dir($themePagesPath) ? $themePagesPath : $defaultPagesPath;

        if (is_dir($pagesPath)) {
            Folio::path($pagesPath)->middleware([
                '*' => [

                ],
            ]);
        }
    }
}
