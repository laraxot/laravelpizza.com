<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCriteriMaggiorazione extends XotBaseEditRecord
{
    protected static string $resource = CriteriMaggiorazioneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
