<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

// use Modules\Geo\Filament\Widgets\LocationMapWidget; // Widget disabilitato per compatibilità Filament v4
use Modules\Xot\Filament\Pages\XotBasePage;

class LocationMap extends XotBasePage
{
    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // LocationMapWidget::class, // Widget disabilitato per compatibilità Filament v4
        ];
    }
}
