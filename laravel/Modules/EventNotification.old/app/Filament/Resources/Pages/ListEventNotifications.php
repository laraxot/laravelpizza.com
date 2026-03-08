<?php

namespace Modules\EventNotification\Filament\Resources\Pages;

use Modules\EventNotification\Filament\Resources\EventNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventNotifications extends ListRecords
{
    protected static string $resource = EventNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}