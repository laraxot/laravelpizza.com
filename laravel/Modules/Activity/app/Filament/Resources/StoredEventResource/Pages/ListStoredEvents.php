<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListStoredEvents extends XotBaseListRecords
{
    protected static string $resource = StoredEventResource::class;

    /**
     * @return array<Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('id'),
            TextColumn::make('event_class'),
            ViewColumn::make('event_properties')->view('activity::filament.tables.columns.event-properties'),
        ];
    }
}
