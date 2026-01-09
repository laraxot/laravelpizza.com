<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ExportResource\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Job\Filament\Resources\ExportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListExports extends XotBaseListRecords
{
    protected static string $resource = ExportResource::class;

    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->numeric()
                ->sortable()
                ->searchable(),
            'name' => TextColumn::make('name')->sortable()->searchable(),
            'status' => TextColumn::make('status')->sortable()->searchable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
