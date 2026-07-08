<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\PhaseResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Incentivi\Filament\Resources\PhaseResource;

class CreatePhase extends CreateRecord
{
    protected static string $resource = PhaseResource::class;
}
