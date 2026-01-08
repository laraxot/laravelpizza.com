<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Pages;

use Modules\User\Filament\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Class EditOauthClient.
 */
class EditOauthClient extends XotBaseEditRecord
{
    protected static string $resource = OauthClientResource::class;
}
