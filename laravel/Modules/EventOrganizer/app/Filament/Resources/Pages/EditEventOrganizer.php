<?php

namespace Modules\EventOrganizer\App\Filament\Resources\Pages;

use Modules\EventOrganizer\App\Filament\Resources\EventOrganizerResource;
use Filament\Resources\Pages\EditRecord;

class EditEventOrganizer extends EditRecord
{
    protected static string $resource = EventOrganizerResource::class;
}