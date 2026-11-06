<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Models\TeamUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class TeamUserResource.
 */
final class TeamUserResource extends XotBaseResource
{
    protected static ?string $model = TeamUser::class;

    #[\Override]
    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['team', 'user']);
    }
}
