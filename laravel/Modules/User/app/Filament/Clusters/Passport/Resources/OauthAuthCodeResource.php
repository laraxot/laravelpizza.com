<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Resources\Pages\PageRegistration;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource\Pages\ListOauthAuthCodes;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource\Pages\ViewOauthAuthCode;
use Modules\User\Models\OauthAuthCode;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class OauthAuthCodeResource.
 */
class OauthAuthCodeResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    protected static ?string $model = OauthAuthCode::class;

    /**
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOauthAuthCodes::route('/'),
            'view' => ViewOauthAuthCode::route('/{record}'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'client']);
    }
}
