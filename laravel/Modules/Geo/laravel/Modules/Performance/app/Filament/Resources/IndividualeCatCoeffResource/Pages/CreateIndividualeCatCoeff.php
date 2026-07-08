<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Pages;

use Modules\Performance\Filament\Resources\IndividualeCatCoeffResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateIndividualeCatCoeff extends XotBaseCreateRecord
{
    protected static string $resource = IndividualeCatCoeffResource::class;
}
