<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * ActivitiesTable Schema.
 */
class ActivitiesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, TextColumn>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'log_name' => TextColumn::make('log_name')
                ->searchable()
                ->sortable(),
            'description' => TextColumn::make('description')
                ->searchable()
                ->sortable(),
            'subject_type' => TextColumn::make('subject_type')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'subject_id' => TextColumn::make('subject_id')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'causer_type' => TextColumn::make('causer_type')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'causer_id' => TextColumn::make('causer_id')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
