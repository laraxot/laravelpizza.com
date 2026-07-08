<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Rating\Providers\Filament;

use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
<<<<<<< HEAD:laravel/Modules/Rating/app/Providers/Filament/AdminPanelProvider.php
    protected string $module = 'Rating';
=======
    protected string $module = 'Geo';

    #[\Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        if (! inAdmin()) {
            return $panel;
        }
        FilamentAsset::register([
            Js::make('coordinate-picker', Vite::asset('resources/js/components/coordinate-picker-lit.js', 'assets/geo'))->module(),
            Js::make('map-picker', Vite::asset('resources/js/components/map-picker-lit.js', 'assets/geo'))->module(),
            Js::make('geopoint-picker', Vite::asset('resources/js/components/geopoint-picker-lit.js', 'assets/geo'))->module(),
            Css::make('coordinate-picker', Vite::asset('resources/css/app.css', 'assets/geo')),
        ]);

        return $panel;
    }
>>>>>>> 74bf6abe2 (.):app/Providers/Filament/AdminPanelProvider.php
}
