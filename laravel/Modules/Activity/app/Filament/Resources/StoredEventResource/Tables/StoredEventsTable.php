<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Modules\Activity\Models\StoredEvent;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * Colonne StoredEvent: aggregate + ViewColumn dedicata per event_properties.
 */
class StoredEventsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<StoredEvent>
     */
    protected static string $model = StoredEvent::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        $eventPropertiesView = 'activity::filament.tables.columns.event-properties';

        return [
            'id' => IDColumn::make('id')->searchable()->sortable(),
            'event_class' => TextColumn::make('event_class')->searchable()->sortable()->wrap(),
            'aggregate_uuid' => TextColumn::make('aggregate_uuid')->searchable()->sortable()->copyable(),
            'aggregate_version' => TextColumn::make('aggregate_version')->numeric()->sortable(),
            'event_version' => TextColumn::make('event_version')->numeric()->sortable(),
            'event_properties' => ViewColumn::make('event_properties')->view($eventPropertiesView),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
