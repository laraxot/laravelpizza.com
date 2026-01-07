<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamPermissionResource\Pages;

use Modules\User\Filament\Resources\TeamPermissionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditTeamPermission extends XotBaseEditRecord
{
    protected static string $resource = TeamPermissionResource::class;
}
