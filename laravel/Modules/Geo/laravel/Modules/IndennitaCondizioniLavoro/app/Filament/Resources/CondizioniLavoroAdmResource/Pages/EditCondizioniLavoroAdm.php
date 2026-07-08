<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCondizioniLavoroAdm extends XotBaseEditRecord
{
    protected static string $resource = CondizioniLavoroAdmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
