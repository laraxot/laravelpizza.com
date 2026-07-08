<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\IndividualeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndividuale extends XotBaseEditRecord
{
    protected static string $resource = IndividualeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
