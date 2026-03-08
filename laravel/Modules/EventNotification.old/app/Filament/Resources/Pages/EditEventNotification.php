<?php

namespace Modules\EventNotification\Filament\Resources\Pages;

use Modules\EventNotification\Filament\Resources\EventNotificationResource;
use Filament\Resources\Pages\EditRecord;

class EditEventNotification extends EditRecord
{
    protected static string $resource = EventNotificationResource::class;
}