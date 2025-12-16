<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

// use Modules\Geo\Filament\Widgets\LocationMapTableWidget; // Widget disabilitato per compatibilità Filament v4
use Modules\Xot\Filament\Pages\XotBasePage;

class LocationMapTable extends XotBasePage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'geo::filament.pages.location-map';

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // LocationMapTableWidget::class, // Widget disabilitato per compatibilità Filament v4
            // Widgets\LocationMapWidget::class,
        ];
    }
}
