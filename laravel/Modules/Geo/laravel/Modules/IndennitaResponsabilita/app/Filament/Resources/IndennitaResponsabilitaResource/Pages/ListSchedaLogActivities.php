<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;

class ListSchedaLogActivities extends ListLogActivities
{
    protected static string $resource = IndennitaResponsabilitaResource::class;
}
