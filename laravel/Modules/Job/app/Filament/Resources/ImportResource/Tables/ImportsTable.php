<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ImportResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ImportsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'importer' => TextColumn::make('importer')->searchable()->sortable(),
            'file_name' => TextColumn::make('file_name')->searchable()->sortable(),
            'file_path' => TextColumn::make('file_path')->searchable(),
            'processed_rows' => TextColumn::make('processed_rows')->sortable(),
            'total_rows' => TextColumn::make('total_rows')->sortable(),
            'successful_rows' => TextColumn::make('successful_rows')->sortable(),
            'user_id' => TextColumn::make('user_id')->searchable()->sortable(),
            'completed_at' => TextColumn::make('completed_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
