<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\MyLogResource\Pages;

use Modules\Performance\Filament\Resources\MyLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateMyLog extends XotBaseCreateRecord
{
    protected static string $resource = MyLogResource::class;
}
