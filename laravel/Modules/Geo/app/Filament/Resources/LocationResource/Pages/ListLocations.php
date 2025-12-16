<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListLocations extends XotBaseListRecords
{
    protected static string $resource = LocationResource::class;

    protected static ?string $title = 'All Locations';

    protected function getHeaderWidgets(): array
    {
        return [
            //            LocationResource\Widgets\LocationMapWidget::class,
        ];
    }

    //    protected function getTableFiltersFormWidth(): string
    //    {
    //        return '4xl';
    //    }
}
