<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Colonne e azioni stanno in `StoredEventsTable`: la List page non le dichiara.
 *
 * @see StoredEventResource
 */
class ListStoredEvents extends XotBaseListRecords
{
    protected static string $resource = StoredEventResource::class;

    /**
     * @return array<Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        $eventPropertiesView = 'activity::filament.tables.columns.event-properties';

        return [
            'id' => IDColumn::make('id'),
            'event_class' => TextColumn::make('event_class'),
            'event_properties' => ViewColumn::make('event_properties')->view($eventPropertiesView),
        ];
    }
}
