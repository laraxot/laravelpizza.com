<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\User\Models\TeamPermission;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TeamPermissionResource extends XotBaseResource
{
    protected static ?string $model = TeamPermission::class;
}
