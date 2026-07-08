<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Incentivi\Filament\Resources\ProjectResource;

class ListSchedaLogActivities extends ListLogActivities
{
    protected static string $resource = ProjectResource::class;
}
