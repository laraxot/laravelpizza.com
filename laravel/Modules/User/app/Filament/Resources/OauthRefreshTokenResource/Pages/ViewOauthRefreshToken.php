<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthRefreshTokenResource\Pages;

use Modules\User\Filament\Resources\OauthRefreshTokenResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewOauthRefreshToken extends XotBaseViewRecord
{
    protected static string $resource = OauthRefreshTokenResource::class;
}
