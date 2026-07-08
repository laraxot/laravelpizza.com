<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ValutatoreResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\ValutatoreResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditValutatore extends XotBaseEditRecord
{
    protected static string $resource = ValutatoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
