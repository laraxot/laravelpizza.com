<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Filament\Resources\BaseStabiDirigenteResource;

class StabiDirigenteResource extends BaseStabiDirigenteResource
{
    protected static ?string $model = StabiDirigente::class;
}
