<?php

declare(strict_types=1);
/**
 * @see https://github.com/Althinect/filament-spatie-roles-permissions/tree/2.x
 * @see https://github.com/phpsa/filament-authentication/blob/main/src/resources/PermissionResource.php
 */

namespace Modules\User\Filament\Resources;

use Modules\User\Filament\Resources\PermissionResource\Pages\CreatePermission;
use Modules\User\Filament\Resources\PermissionResource\Pages\EditPermission;
use Modules\User\Filament\Resources\PermissionResource\Pages\ListPermissions;
use Modules\User\Models\Permission;
use Modules\Xot\Filament\Resources\XotBaseResource;

class PermissionResource extends XotBaseResource
{
    protected static ?string $model = Permission::class;

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
        ];
    }
}
