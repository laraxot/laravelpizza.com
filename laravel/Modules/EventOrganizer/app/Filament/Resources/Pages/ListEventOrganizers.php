<?php

namespace Modules\EventOrganizer\App\Filament\Resources\Pages;

use Modules\EventOrganizer\App\Filament\Resources\EventOrganizerResource;
use Filament\Resources\Pages\ListRecords;

class ListEventOrganizers extends ListRecords
{
    protected static string $resource = EventOrganizerResource::class;

    protected function getActions(): array
    {
        return [
            \Modules\EventOrganizer\App\Filament\Resources\Pages\CreateEventOrganizer::make(),
        ];
    }
}