<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedImportRowResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class FailedImportRowsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'import_id' => TextColumn::make('import_id')->sortable(),
            'validation_error' => TextColumn::make('validation_error')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
