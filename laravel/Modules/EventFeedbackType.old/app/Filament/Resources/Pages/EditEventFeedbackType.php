<?php

namespace Modules\EventFeedbackType\Filament\Resources\Pages;

use Modules\EventFeedbackType\Filament\Resources\EventFeedbackTypeResource;
use Filament\Resources\Pages\EditRecord;

class EditEventFeedbackType extends EditRecord
{
    protected static string $resource = EventFeedbackTypeResource::class;
}