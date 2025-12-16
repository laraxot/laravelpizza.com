<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateAddress extends XotBaseCreateRecord
{
    protected static string $resource = AddressResource::class;
}
