<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\IndividualeCatCoeffResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndividualeCatCoeff extends XotBaseEditRecord
{
    protected static string $resource = IndividualeCatCoeffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
