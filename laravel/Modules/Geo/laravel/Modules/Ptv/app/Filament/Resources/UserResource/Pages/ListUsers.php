<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\UserResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Ptv\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListUsers extends XotBaseListRecords
{
    protected static string $resource = UserResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->numeric()
                ->sortable(),
            'name' => TextColumn::make('name')
                ->searchable(),
            'email' => TextColumn::make('email')
                ->searchable(),
        ];
    }
}
