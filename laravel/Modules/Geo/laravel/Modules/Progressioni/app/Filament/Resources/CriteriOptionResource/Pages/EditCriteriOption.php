<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriOptionResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\CriteriOptionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCriteriOption extends XotBaseEditRecord
{
    protected static string $resource = CriteriOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
