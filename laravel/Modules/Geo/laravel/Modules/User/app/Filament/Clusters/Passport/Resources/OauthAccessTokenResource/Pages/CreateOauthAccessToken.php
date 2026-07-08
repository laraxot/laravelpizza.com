<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateOauthAccessToken extends XotBaseCreateRecord
{
    protected static string $resource = OauthAccessTokenResource::class;

    public static function getNavigationLabel(): string
    {
        return 'Create Access Token';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-plus';
    }
}
