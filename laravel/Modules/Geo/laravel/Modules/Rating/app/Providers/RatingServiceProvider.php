<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Rating\Providers;

<<<<<<< HEAD:laravel/Modules/Rating/app/Providers/RatingServiceProvider.php
use Modules\Xot\Providers\XotBaseServiceProvider;

class RatingServiceProvider extends XotBaseServiceProvider
=======
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Modules\Xot\Providers\XotBaseServiceProvider;

class GeoServiceProvider extends XotBaseServiceProvider
>>>>>>> 74bf6abe2 (.):app/Providers/GeoServiceProvider.php
{
    public string $name = 'Rating';

    protected string $moduleName = 'Geo';

    protected string $namespace = 'geo';

    public function boot(): void
    {
        parent::boot();

        $this->registerMapAssets();
    }

    protected function registerMapAssets(): void
    {
        FilamentAsset::register([
            Js::make('map-picker-geo', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'),
            Js::make('map-picker-lit', asset('themes/Geo/js/geo.js')),
        ], 'geo');

        FilamentAsset::register([
            Css::make('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'),
        ], 'geo');
    }

    // REMOVED: public function register(): void
    // XotBaseServiceProvider gia' gestisce register() con registerBladeIcons().
    // Non sovrascrivere: causa doppia registrazione del prefix "geo" nei BladeIcons.
}
