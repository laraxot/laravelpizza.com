<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Pages;

use Modules\Progressioni\Filament\Resources\ProgressioniResource;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\BaseListSchedas;

class ListProgressionis extends BaseListSchedas
{
    protected static string $resource = ProgressioniResource::class;
}
