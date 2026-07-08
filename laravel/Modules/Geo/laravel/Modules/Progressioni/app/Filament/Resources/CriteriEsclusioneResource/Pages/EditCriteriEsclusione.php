<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriEsclusioneResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\CriteriEsclusioneResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCriteriEsclusione extends XotBaseEditRecord
{
    protected static string $resource = CriteriEsclusioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
