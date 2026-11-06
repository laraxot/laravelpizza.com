<?php

declare(strict_types=1);
/**
 * @see https://github.com/savannabits/filament-tenancy-starter/blob/main/app/Filament/resources/TenantResource.php
 */

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Resources\TenantResource\Pages\CreateTenant;
use Modules\User\Filament\Resources\TenantResource\Pages\EditTenant;
use Modules\User\Filament\Resources\TenantResource\Pages\ListTenants;
use Modules\User\Filament\Resources\TenantResource\Pages\ViewTenant;
use Modules\User\Filament\Resources\TenantResource\RelationManagers\UsersRelationManager;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TenantResource extends XotBaseResource
{
    /**
     * Get the model class name for this resource.
     *
     * @return class-string<Model>
     */
    #[\Override]
    public static function getModel(): string
    {
        $xot = XotData::make();

        return $xot->getTenantClass();
    }

    #[\Override]
    public static function getRelations(): array
    {
        return [
            // RelationManagers\DomainsRelationManager::class,
            UsersRelationManager::class,
        ];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'view' => ViewTenant::route('/{record}'),
            'edit' => EditTenant::route('/{record}/edit'),
        ];
    }
}
