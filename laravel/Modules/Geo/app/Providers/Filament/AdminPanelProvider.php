<?php

declare(strict_types=1);

namespace Modules\Geo\Providers\Filament;

use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Vite;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

/**
 * Pannello Filament del modulo Geo.
 *
 * Registra gli asset del coordinate picker solo quando la build Vite è disponibile.
 */
class AdminPanelProvider extends XotBasePanelProvider
{
    public const string BUILD_DIRECTORY = 'assets/geo';

    protected string $module = 'Geo';

    #[\Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        if (! inAdmin()) {
            return $panel;
        }

        if (! static::assetsAreAvailable()) {
            Log::warning('Geo: build Vite assente, coordinate picker non registrato.', [
                'manifest' => public_path(self::BUILD_DIRECTORY.'/manifest.json'),
            ]);

            return $panel;
        }

        FilamentAsset::register([
            Js::make('coordinate-picker', Vite::asset('resources/js/components/coordinate-picker-lit.js', self::BUILD_DIRECTORY))->module(),
            Css::make('coordinate-picker', asset(self::BUILD_DIRECTORY.'/assets/coordinate-picker-lit.css')),
        ]);

        return $panel;
    }

    public static function assetsAreAvailable(?string $publicRoot = null): bool
    {
        $root = rtrim($publicRoot ?? public_path(), DIRECTORY_SEPARATOR);

        return File::exists($root.DIRECTORY_SEPARATOR.'hot')
            || File::exists($root.DIRECTORY_SEPARATOR.self::BUILD_DIRECTORY.'/manifest.json');
    }
}
