<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Pages;

use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

abstract class BaseEditCriteriEsclusione extends XotBaseEditRecord
{
    protected static string $resource = CriteriEsclusioneResource::class;
}
