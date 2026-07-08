<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePesiResource\Pages;

use Modules\Performance\Filament\Resources\IndividualePesiResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateIndividualePesi extends XotBaseCreateRecord
{
    protected static string $resource = IndividualePesiResource::class;
}
