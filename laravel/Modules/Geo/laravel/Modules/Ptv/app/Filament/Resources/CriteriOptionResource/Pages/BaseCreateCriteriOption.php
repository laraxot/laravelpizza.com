<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Ptv\Filament\Resources\CriteriOptionResource;

abstract class BaseCreateCriteriOption extends CreateRecord
{
    protected static string $resource = CriteriOptionResource::class;
}
