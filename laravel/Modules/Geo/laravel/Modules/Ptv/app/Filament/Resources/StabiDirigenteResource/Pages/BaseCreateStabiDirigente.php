<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource;

abstract class BaseCreateStabiDirigente extends CreateRecord
{
    protected static string $resource = StabiDirigenteResource::class;
}
