<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCriteriPrecedenza extends XotBaseEditRecord
{
    protected static string $resource = CriteriPrecedenzaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
