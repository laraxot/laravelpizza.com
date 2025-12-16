<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditLocation extends XotBaseEditRecord
{
    protected static string $resource = LocationResource::class;
}
