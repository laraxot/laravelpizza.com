<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages;

use Modules\Performance\Filament\Resources\PerformanceFondoResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreatePerformanceFondo extends XotBaseCreateRecord
{
    protected static string $resource = PerformanceFondoResource::class;
}
