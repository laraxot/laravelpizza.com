<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Pages;

use Modules\User\Filament\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

/**
 * Class CreateOauthClient.
 */
class CreateOauthClient extends XotBaseCreateRecord
{
    protected static string $resource = OauthClientResource::class;
}
