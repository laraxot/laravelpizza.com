<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateOauthClient extends XotBaseCreateRecord
{
    protected static string $resource = OauthClientResource::class;
}
