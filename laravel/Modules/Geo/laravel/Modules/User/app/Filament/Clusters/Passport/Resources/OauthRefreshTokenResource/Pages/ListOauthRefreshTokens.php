<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListOauthRefreshTokens extends XotBaseListRecords
{
    protected static string $resource = OauthRefreshTokenResource::class;
}
