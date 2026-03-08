<?php

namespace Modules\EventAttendee\Filament\Resources\Pages;

use Modules\EventAttendee\Filament\Resources\EventAttendeeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventAttendee extends CreateRecord
{
    protected static string $resource = EventAttendeeResource::class;
}