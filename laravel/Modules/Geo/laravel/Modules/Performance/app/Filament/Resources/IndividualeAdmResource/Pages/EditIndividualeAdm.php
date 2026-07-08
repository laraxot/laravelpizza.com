<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAdmResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\IndividualeAdmResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndividualeAdm extends XotBaseEditRecord
{
    protected static string $resource = IndividualeAdmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
