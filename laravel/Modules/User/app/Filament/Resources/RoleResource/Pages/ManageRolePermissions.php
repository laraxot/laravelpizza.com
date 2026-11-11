<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Pages;

use Modules\User\Filament\Resources\RoleResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;

/**
 * `table()` è `final` su {@see XotBaseManageRelatedRecords}: qui si usano
 * solo i 5 hook di contenuto (colonne, azioni header/riga/bulk, filtri),
 * mai un override di `table()` per intero.
 */
class ManageRolePermissions extends XotBaseManageRelatedRecords
{
    protected static string $resource = RoleResource::class;

    protected static string $relationship = 'permissions';
}
