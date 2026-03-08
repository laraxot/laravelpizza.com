<?php

namespace Modules\EventAnalytics\Filament\Resources\Pages;

use Modules\EventAnalytics\Filament\Resources\EventAnalyticsResource;
use Filament\Resources\Pages\EditRecord;

class EditEventAnalytics extends EditRecord
{
    protected static string $resource = EventAnalyticsResource::class;
}