<?php

declare(strict_types=1);

namespace Modules\Cms\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('Cms_admin')
            ->path('Cms/admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: __DIR__.'/Resources', for: 'Modules\\Cms\\Filament\\Resources')
            ->discoverPages(in: __DIR__.'/Pages', for: 'Modules\\Cms\\Filament\\Pages')
            ->discoverWidgets(in: __DIR__.'/Widgets', for: 'Modules\\Cms\\Filament\\Widgets')
            ->discoverClusters(in: __DIR__.'/Clusters', for: 'Modules\\Cms\\Filament\\Clusters');
    }
}
