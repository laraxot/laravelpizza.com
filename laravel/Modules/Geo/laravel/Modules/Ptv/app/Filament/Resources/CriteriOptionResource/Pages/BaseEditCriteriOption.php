<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriOptionResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Ptv\Filament\Resources\CriteriOptionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

abstract class BaseEditCriteriOption extends XotBaseEditRecord
{
    protected static string $resource = CriteriOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
