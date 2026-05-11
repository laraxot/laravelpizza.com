<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAuthCodeResource\Pages;

use Modules\User\Filament\Resources\OauthAuthCodeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Class ListOauthAuthCodes.
 */
class ListOauthAuthCodes extends XotBaseListRecords
{
    protected static string $resource = OauthAuthCodeResource::class;
}
