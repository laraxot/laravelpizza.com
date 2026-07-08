<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MyLogResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MyLogsTable extends XotBaseResourceTable
{
    /**
     * Convertito da ListMyLogs::getHeaderActions() al contesto classe Table.
     *
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

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
