<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Models\TenantUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class TenantUserResource.
 */
final class TenantUserResource extends XotBaseResource
{
    protected static ?string $model = TenantUser::class;

    #[\Override]
    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['tenant', 'user']);
    }
}
