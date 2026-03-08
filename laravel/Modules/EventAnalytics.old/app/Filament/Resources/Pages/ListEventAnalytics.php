<?php

namespace Modules\EventAnalytics\Filament\Resources\Pages;

use Modules\EventAnalytics\Filament\Resources\EventAnalyticsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventAnalytics extends ListRecords
{
    protected static string $resource = EventAnalyticsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}