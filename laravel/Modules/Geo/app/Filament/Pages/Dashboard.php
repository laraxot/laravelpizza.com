<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

final class Dashboard extends XotBaseDashboard
{
    /**
     * @return array<string, mixed>
     */
    public function getWidgets(): array
    {
        return [
            'geo_map' => GeoMapWidget::class,
        ];
    }

    public function getColumns(): int
    {
        return 1;
    }
}
