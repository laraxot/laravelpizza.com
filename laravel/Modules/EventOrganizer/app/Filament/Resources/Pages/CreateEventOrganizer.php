<?php

namespace Modules\EventOrganizer\App\Filament\Resources\Pages;

use Modules\EventOrganizer\App\Filament\Resources\EventOrganizerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventOrganizer extends CreateRecord
{
    protected static string $resource = EventOrganizerResource::class;
}