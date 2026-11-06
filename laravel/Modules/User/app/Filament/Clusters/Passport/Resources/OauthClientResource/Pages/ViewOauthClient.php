<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

/**
 * Class ViewOauthClient.
 */
class ViewOauthClient extends XotBaseViewRecord
{
    protected static string $resource = OauthClientResource::class;
}
