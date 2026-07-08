<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\StipendioTabellareResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\StipendioTabellareResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditStipendioTabellare extends XotBaseEditRecord
{
    protected static string $resource = StipendioTabellareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
