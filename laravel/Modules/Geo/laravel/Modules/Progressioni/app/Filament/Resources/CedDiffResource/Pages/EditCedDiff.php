<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CedDiffResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\CedDiffResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCedDiff extends XotBaseEditRecord
{
    protected static string $resource = CedDiffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
