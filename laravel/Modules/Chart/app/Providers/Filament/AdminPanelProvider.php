<?php

declare(strict_types=1);

namespace Modules\Chart\Providers\Filament;

use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Chart';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        // $panel->assets([
        //    Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
        // ]);
        try {
            FilamentAsset::register([
                Js::make('chart-js-plugins', Vite::asset('resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
                Css::make('chart-js-plugins', Vite::asset('resources/css/app.css', 'assets/chart')),
            ]);
        } catch (\Exception $e) {
            // Only for preventing crash during composer update/install
            // Log::warning($e->getMessage());
        }

        return $panel;
    }
}
