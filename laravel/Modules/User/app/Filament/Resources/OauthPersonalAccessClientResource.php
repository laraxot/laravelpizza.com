<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Models\OauthPersonalAccessClient;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class OauthPersonalAccessClientResource.
 */
final class OauthPersonalAccessClientResource extends XotBaseResource
{
    protected static ?string $model = OauthPersonalAccessClient::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'OAuth Personal Access Client';

    protected static ?string $pluralModelLabel = 'OAuth Personal Access Clients';

    protected static \UnitEnum|string|null $navigationGroup = 'API';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-key';

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['client']);
    }
}
