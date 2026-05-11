<?php

declare(strict_types=1);

namespace Modules\Geo\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Modules\Xot\Providers\XotBaseServiceProvider;

use function Safe\file_get_contents;
use function Safe\json_decode;

class GeoServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Geo';

    protected string $moduleName = 'Geo';

    protected string $namespace = 'geo';

    public function boot(): void
    {
        parent::boot();

        $this->registerMapAssets();
    }

    protected function registerMapAssets(): void
    {
        $assets = [];

        if (is_file(public_path('themes/Geo/css/leaflet.css'))) {
            $assets[] = Css::make('leaflet-css', asset('themes/Geo/css/leaflet.css'));
        }

        $sixteenBundleUrl = $this->getSixteenThemeAppBundleUrl();

        if (null !== $sixteenBundleUrl) {
            // Admin Filament non carica automaticamente il bundle frontoffice del tema,
            // ma il CoordinatePicker Lit e i suoi controlli sono definiti li'.
            $assets[] = Js::make('sixteen-coordinate-picker-bundle', $sixteenBundleUrl)->module();
        }

        if ([] !== $assets) {
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

        if ('' === $manifestRaw) {
            return null;
        }

        /** @var array<string, array{file?: string}>|null $manifest */
        $manifest = json_decode($manifestRaw, true);

        if (! is_array($manifest)) {
            return null;
        }

        $entry = $manifest['resources/js/app.js']['file'] ?? null;

        if (! is_string($entry) || '' === $entry) {
            return null;
        }

        return asset('themes/Sixteen/'.$entry);
    }

    // REMOVED: public function register(): void
    // XotBaseServiceProvider gia' gestisce register() con registerBladeIcons().
    // Non sovrascrivere: causa doppia registrazione del prefix "geo" nei BladeIcons.
}
