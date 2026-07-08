<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeTotStabiResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\IndividualeTotStabiResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditIndividualeTotStabi extends XotBaseEditRecord
{
    protected static string $resource = IndividualeTotStabiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
