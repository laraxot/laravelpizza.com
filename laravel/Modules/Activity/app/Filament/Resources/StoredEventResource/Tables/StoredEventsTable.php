<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class StoredEventsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        $eventPropertiesView = 'activity::filament.tables.columns.event-properties';

        return [
            'id' => IDColumn::make('id')->searchable()->sortable(),
            'event_class' => TextColumn::make('event_class')->searchable(),
            'event_properties' => ViewColumn::make('event_properties')->view($eventPropertiesView),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }
}
