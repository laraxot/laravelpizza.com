<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('Gdpr_admin')
            ->path('Gdpr/admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: __DIR__.'/Resources', for: 'Modules\\Gdpr\\Filament\\Resources')
            ->discoverPages(in: __DIR__.'/Pages', for: 'Modules\\Gdpr\\Filament\\Pages')
            ->discoverWidgets(in: __DIR__.'/Widgets', for: 'Modules\\Gdpr\\Filament\\Widgets')
            ->discoverClusters(in: __DIR__.'/Clusters', for: 'Modules\\Gdpr\\Filament\\Clusters');
    }
}
