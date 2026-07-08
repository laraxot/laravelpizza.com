<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\ReportResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\StabiDirigenteResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditStabiDirigente extends XotBaseEditRecord
{
    protected static string $resource = StabiDirigenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
