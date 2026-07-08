<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CoeffResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\CoeffResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCoeff extends XotBaseEditRecord
{
    protected static string $resource = CoeffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
