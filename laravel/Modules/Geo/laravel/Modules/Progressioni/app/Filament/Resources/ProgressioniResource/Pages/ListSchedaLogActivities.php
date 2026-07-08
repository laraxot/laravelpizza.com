<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Pages;

// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Progressioni\Filament\Resources\ProgressioniResource;

class ListSchedaLogActivities extends ListLogActivities
{
    protected static string $resource = ProgressioniResource::class;
}
