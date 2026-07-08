<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Ptv\Filament\Resources\BaseCriteriEsclusioneResource;

class CriteriEsclusioneResource extends BaseCriteriEsclusioneResource
{
    protected static ?string $model = CriteriEsclusione::class;
}
