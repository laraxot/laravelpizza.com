<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndividualeDecurtazioneAssenze extends XotBaseEditRecord
{
    protected static string $resource = IndividualeDecurtazioneAssenzeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
