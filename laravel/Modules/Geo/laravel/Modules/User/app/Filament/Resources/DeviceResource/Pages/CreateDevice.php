<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\DeviceResource\Pages;

use Modules\User\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateDevice extends XotBaseCreateRecord
{
    protected static string $resource = DeviceResource::class;
}
