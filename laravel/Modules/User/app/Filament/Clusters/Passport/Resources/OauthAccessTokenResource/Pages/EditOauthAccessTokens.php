<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditOauthAccessTokens extends XotBaseEditRecord
{
    protected static string $resource = OauthAccessTokenResource::class;
}
