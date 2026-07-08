<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\PesiResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\PesiResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPesi extends XotBaseEditRecord
{
    protected static string $resource = PesiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
