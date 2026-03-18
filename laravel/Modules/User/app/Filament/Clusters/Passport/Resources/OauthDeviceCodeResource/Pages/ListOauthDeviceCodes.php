<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthDeviceCodeResource\Pages;

use Modules\User\Filament\Clusters\Passport\Resources\OauthDeviceCodeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListOauthDeviceCodes extends XotBaseListRecords
{
    protected static string $resource = OauthDeviceCodeResource::class;
}
