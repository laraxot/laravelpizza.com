<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeRegionaleResource\Pages;

use Modules\Performance\Filament\Resources\IndividualeRegionaleResource;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\FillOutTheForm as BaseFillOutTheForm;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\BaseCompilaScheda;

class CompilaScheda extends BaseCompilaScheda
{
    protected static string $resource = IndividualeRegionaleResource::class;
}
