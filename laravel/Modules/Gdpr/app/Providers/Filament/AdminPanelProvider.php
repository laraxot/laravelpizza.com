<?php

declare(strict_types=1);

namespace Modules\Gdpr\Providers\Filament;

use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Gdpr';

    #[\Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        FilamentAsset::register(
            [
                // Percorso del file, non URL: `php artisan filament:assets` lo copia nella cartella pubblica servita
                // (public_html/css/gdpr). L'URL /vendor/cookie-consent/... puntava a laravel/public, non servita: 404 su ogni pagina.
                Css::make('gdpr-styles', __DIR__.'/../../../resources/dist/cookie-consent.css'),
                // Js::make('gdpr-scripts', __DIR__.'/../../resources/dist/assets/app2.js'),
            ],
            'gdpr',
        );

        return $panel;
    }
}
