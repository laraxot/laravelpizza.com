<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\MyLogResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\MyLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditMyLog extends XotBaseEditRecord
{
    protected static string $resource = MyLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
