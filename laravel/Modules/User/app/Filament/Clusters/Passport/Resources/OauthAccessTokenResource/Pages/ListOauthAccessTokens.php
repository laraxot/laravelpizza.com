<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListOauthAccessTokens extends XotBaseListRecords
{
    protected static string $resource = OauthAccessTokenResource::class;
}
