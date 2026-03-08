<?php

namespace Modules\EventAnalytics\Filament\Resources\Pages;

use Modules\EventAnalytics\Filament\Resources\EventAnalyticsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventAnalytics extends CreateRecord
{
    protected static string $resource = EventAnalyticsResource::class;
}