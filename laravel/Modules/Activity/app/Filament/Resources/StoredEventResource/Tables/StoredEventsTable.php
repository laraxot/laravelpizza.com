<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
<<<<<<< .merge_file_BQmGKC
use Modules\Activity\Models\StoredEvent;
=======
use Filament\Tables\Columns\ViewColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
>>>>>>> .merge_file_h4AXSP
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\json_encode;

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
<<<<<<< .merge_file_BQmGKC
            'event_class' => TextColumn::make('event_class')->searchable()->sortable()->wrap(),
            'aggregate_uuid' => TextColumn::make('aggregate_uuid')->searchable()->sortable()->copyable(),
            'aggregate_version' => TextColumn::make('aggregate_version')->numeric()->sortable(),
            'event_version' => TextColumn::make('event_version')->numeric()->sortable(),
            'event_properties' => TextColumn::make('event_properties')
                ->state(static fn (StoredEvent $record): string => json_encode($record->event_properties, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->limit(100)
                ->wrap()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'id' => TextColumn::make('id')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
=======
            'id' => IDColumn::make('id')->searchable()->sortable(),
            'event_class' => TextColumn::make('event_class')->searchable(),
            'event_properties' => ViewColumn::make('event_properties')->view($eventPropertiesView),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
>>>>>>> .merge_file_h4AXSP
        ];
    }
}
