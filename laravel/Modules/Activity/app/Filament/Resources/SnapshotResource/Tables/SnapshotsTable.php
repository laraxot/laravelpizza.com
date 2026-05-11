<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\SnapshotResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * SnapshotsTable Schema.
 */
class SnapshotsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, TextColumn>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'model_type' => TextColumn::make('model_type')
                ->searchable()
                ->sortable(),
            'model_id' => TextColumn::make('model_id')
                ->sortable(),
            'created_by_type' => TextColumn::make('created_by_type')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_by_id' => TextColumn::make('created_by_id')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
