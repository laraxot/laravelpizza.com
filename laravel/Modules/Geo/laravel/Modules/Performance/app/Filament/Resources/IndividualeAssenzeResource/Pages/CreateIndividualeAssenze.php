<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Pages;

use Modules\Performance\Filament\Resources\IndividualeAssenzeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateIndividualeAssenze extends XotBaseCreateRecord
{
    protected static string $resource = IndividualeAssenzeResource::class;
}
