<?php

namespace Modules\EventAttendee\Filament\Resources\Pages;

use Modules\EventAttendee\Filament\Resources\EventAttendeeResource;
use Filament\Resources\Pages\EditRecord;

class EditEventAttendee extends EditRecord
{
    protected static string $resource = EventAttendeeResource::class;
}