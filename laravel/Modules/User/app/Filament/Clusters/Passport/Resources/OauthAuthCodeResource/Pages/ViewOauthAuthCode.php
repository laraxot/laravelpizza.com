<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewOauthAuthCode extends XotBaseViewRecord
{
    protected static string $resource = OauthAuthCodeResource::class;
}
