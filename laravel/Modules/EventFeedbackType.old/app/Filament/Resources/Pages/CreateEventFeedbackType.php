<?php

namespace Modules\EventFeedbackType\Filament\Resources\Pages;

use Modules\EventFeedbackType\Filament\Resources\EventFeedbackTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventFeedbackType extends CreateRecord
{
    protected static string $resource = EventFeedbackTypeResource::class;
}