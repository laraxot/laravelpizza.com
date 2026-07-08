<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriValutazioneResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\CriteriValutazioneResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCriteriValutazione extends XotBaseEditRecord
{
    protected static string $resource = CriteriValutazioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
