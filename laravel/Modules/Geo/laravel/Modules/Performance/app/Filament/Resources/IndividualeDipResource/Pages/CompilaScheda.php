<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeDipResource\Pages;

use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Modules\Performance\Filament\Resources\IndividualeDipResource;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\FillOutTheForm as BaseFillOutTheForm;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\BaseCompilaScheda;
use Modules\Xot\Actions\GetTransKeyAction;

/**
 * @property Schema $form
 * @property Model  $record
 */
class CompilaScheda extends BaseCompilaScheda
{
    protected static string $resource = IndividualeDipResource::class;

   
}
