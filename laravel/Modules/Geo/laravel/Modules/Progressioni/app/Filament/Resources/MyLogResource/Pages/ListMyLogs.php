<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MyLogResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\MyLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListMyLogs extends XotBaseListRecords
{
    protected static string $resource = MyLogResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'id_tbl' => TextColumn::make('id_tbl')
                ->numeric()
                ->sortable(),
            'tbl' => TextColumn::make('tbl')
                ->searchable()
                ->sortable(),
            'id_approvaz' => TextColumn::make('id_approvaz')
                ->numeric()
                ->sortable(),
            'note' => TextColumn::make('note')
                ->searchable()
                ->sortable(),
            'obj' => TextColumn::make('obj')
                ->searchable()
                ->sortable(),
            'act' => TextColumn::make('act')
                ->searchable()
                ->sortable(),
            'datemod' => TextColumn::make('datemod')
                ->sortable(),
            'handle' => TextColumn::make('handle')
                ->searchable()
                ->sortable(),
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
