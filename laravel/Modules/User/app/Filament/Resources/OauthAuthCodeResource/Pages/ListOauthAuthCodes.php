<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAuthCodeResource\Pages;

use Modules\User\Filament\Resources\OauthAuthCodeResource;
/**
 * Class ListOauthAuthCodes.
 */
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListOauthAuthCodes extends XotBaseListRecords
{
    protected static string $resource = OauthAuthCodeResource::class;
}
