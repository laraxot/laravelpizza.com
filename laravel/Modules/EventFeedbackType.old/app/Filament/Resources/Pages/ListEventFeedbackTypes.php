<?php

namespace Modules\EventFeedbackType\Filament\Resources\Pages;

use Modules\EventFeedbackType\Filament\Resources\EventFeedbackTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventFeedbackTypes extends ListRecords
{
    protected static string $resource = EventFeedbackTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}