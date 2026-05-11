<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * StoredEventsTable Schema.
 */
class StoredEventsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, TextColumn>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'event_class' => TextColumn::make('event_class')
                ->searchable()
                ->sortable(),
            'aggregate_uuid' => TextColumn::make('aggregate_uuid')
                ->searchable()
                ->sortable(),
            'aggregate_version' => TextColumn::make('aggregate_version')
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
