<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAuthCodeResource\Pages;

use Modules\User\Filament\Resources\OauthAuthCodeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewOauthAuthCode extends XotBaseViewRecord
{
    protected static string $resource = OauthAuthCodeResource::class;
}
