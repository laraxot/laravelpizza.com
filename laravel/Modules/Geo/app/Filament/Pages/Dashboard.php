<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

final class Dashboard extends XotBaseDashboard
{
    /**
     * @return list<class-string>
     */
    public function getWidgets(): array
    {
        return [
            GeoMapWidget::class,
        ];
    }

    public function getColumns(): int
    {
        return 1;
    }
}
