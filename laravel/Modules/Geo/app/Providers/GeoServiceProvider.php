<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Blade;
use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Contracts\CalculateDistanceActionContract;
use Modules\Xot\Providers\XotBaseServiceProvider;

use function Safe\file_get_contents;
use function Safe\json_decode;

class GeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Geo';

    protected string $moduleName = 'Geo';

    protected string $namespace = 'geo';

    public function register(): void
    {
        parent::register();

        $this->app->bind(CalculateDistanceActionContract::class, CalculateDistanceAction::class);
    }

    public function boot(): void
    {
        parent::boot();

        // GeoServiceProvider non ridefinisce $module_ns: la base lo deriva da Xot e registrerebbe `geo` su
        // Modules\Xot\View\Components. Senza questa riga `<x-geo::point-map>` non trova la classe.
        Blade::componentNamespace('Modules\\Geo\\View\\Components', 'geo');

        // $this->registerMapAssets();
    }

    protected function registerMapAssets(): void
    {
        $assets = [];

        if (is_file(public_path('themes/Geo/css/leaflet.css'))) {
            $assets[] = Css::make('leaflet-css', asset('themes/Geo/css/leaflet.css'));
        }

        $sixteenBundleUrl = $this->getSixteenThemeAppBundleUrl();

        if ($sixteenBundleUrl !== null) {
            // Admin Filament non carica automaticamente il bundle frontoffice del tema,
            // ma il CoordinatePicker Lit e i suoi controlli sono definiti li'.
            $assets[] = Js::make('sixteen-coordinate-picker-bundle', $sixteenBundleUrl)->module();
        }

        if ($assets !== []) {
            FilamentAsset::register($assets, 'geo');
        }
    }

    protected function getSixteenThemeAppBundleUrl(): ?string
    {
        $manifestPath = public_path('themes/Sixteen/manifest.json');

        if (! is_file($manifestPath)) {
            return null;
        }

        $manifestRaw = file_get_contents($manifestPath);

        /** @var array<string, array{file?: string}> $manifest */
        $manifest = json_decode($manifestRaw, true);

        $entry = $manifest['resources/js/app.js']['file'] ?? null;

        if (! is_string($entry) || $entry === '') {
            return null;
        }

        return asset('themes/Sixteen/'.$entry);
    }

    // REMOVED: public function register(): void
    // XotBaseServiceProvider gia' gestisce register() con registerBladeIcons().
    // Non sovrascrivere: causa doppia registrazione del prefix "geo" nei BladeIcons.
}
