<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\DeviceResource\Pages;

use Modules\User\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListDevices extends XotBaseListRecords
{
    protected static string $resource = DeviceResource::class;
}
