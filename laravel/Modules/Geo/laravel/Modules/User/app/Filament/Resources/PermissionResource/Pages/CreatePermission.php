<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PermissionResource\Pages;

use Modules\User\Filament\Resources\PermissionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreatePermission extends XotBaseCreateRecord
{
    // //
    protected static string $resource = PermissionResource::class;
}
