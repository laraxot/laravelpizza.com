<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthPersonalAccessClientResource\Pages;

use Modules\User\Filament\Resources\OauthPersonalAccessClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

/**
 * Class ViewOauthPersonalAccessClient.
 */
class ViewOauthPersonalAccessClient extends XotBaseViewRecord
{
    protected static string $resource = OauthPersonalAccessClientResource::class;
}
