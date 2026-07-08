<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndennitaTipo extends XotBaseEditRecord
{
    protected static string $resource = IndennitaTipoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
