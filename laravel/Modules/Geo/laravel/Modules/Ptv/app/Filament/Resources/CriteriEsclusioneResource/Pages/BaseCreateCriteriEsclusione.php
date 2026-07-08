<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource;

abstract class BaseCreateCriteriEsclusione extends CreateRecord
{
    protected static string $resource = CriteriEsclusioneResource::class;
}
