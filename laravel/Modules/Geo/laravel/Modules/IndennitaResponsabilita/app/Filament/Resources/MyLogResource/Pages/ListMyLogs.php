<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MyLogResource\Pages;

use Modules\IndennitaResponsabilita\Filament\Resources\MyLogResource;
use Modules\Ptv\Filament\Resources\MyLogResource\Pages\BaseListMyLogs;

class ListMyLogs extends BaseListMyLogs
{
    protected static string $resource = MyLogResource::class;
}
