<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateLocation extends XotBaseCreateRecord
{
    protected static string $resource = LocationResource::class;
}
