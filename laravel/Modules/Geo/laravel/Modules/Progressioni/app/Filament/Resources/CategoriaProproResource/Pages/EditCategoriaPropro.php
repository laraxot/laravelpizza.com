<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CategoriaProproResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Progressioni\Filament\Resources\CategoriaProproResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditCategoriaPropro extends XotBaseEditRecord
{
    protected static string $resource = CategoriaProproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
