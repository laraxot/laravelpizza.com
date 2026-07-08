<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MyLogResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Progressioni\Filament\Resources\MyLogResource;

class CreateMyLog extends CreateRecord
{
    protected static string $resource = MyLogResource::class;
}
