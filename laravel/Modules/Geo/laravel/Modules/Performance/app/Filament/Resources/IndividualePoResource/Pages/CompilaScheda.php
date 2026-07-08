<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePoResource\Pages;

use Modules\Performance\Filament\Resources\IndividualePoResource;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\FillOutTheForm as BaseFillOutTheForm;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\BaseCompilaScheda;
use Modules\Xot\Actions\GetTransKeyAction;

class CompilaScheda extends BaseCompilaScheda
{
    protected static string $resource = IndividualePoResource::class;

    
}
