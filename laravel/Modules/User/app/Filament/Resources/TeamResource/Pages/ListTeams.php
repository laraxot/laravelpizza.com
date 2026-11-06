<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\Pages;

use Modules\User\Filament\Resources\TeamResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListTeams extends XotBaseListRecords
{
    // //
    protected static string $resource = TeamResource::class;
}
