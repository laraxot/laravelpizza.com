<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePesiResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\IndividualePesiResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndividualePesi extends XotBaseEditRecord
{
    protected static string $resource = IndividualePesiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
