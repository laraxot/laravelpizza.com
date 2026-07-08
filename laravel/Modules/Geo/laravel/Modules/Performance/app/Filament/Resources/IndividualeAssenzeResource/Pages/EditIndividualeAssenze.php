<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\IndividualeAssenzeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndividualeAssenze extends XotBaseEditRecord
{
    protected static string $resource = IndividualeAssenzeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
