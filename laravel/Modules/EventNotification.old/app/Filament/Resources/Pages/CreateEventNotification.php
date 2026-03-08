<?php

namespace Modules\EventNotification\Filament\Resources\Pages;

use Modules\EventNotification\Filament\Resources\EventNotificationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventNotification extends CreateRecord
{
    protected static string $resource = EventNotificationResource::class;
}