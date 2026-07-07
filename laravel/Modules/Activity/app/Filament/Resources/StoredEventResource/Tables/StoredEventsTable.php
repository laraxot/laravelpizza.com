<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Tables;

<<<<<<< HEAD
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
=======
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class StoredEventsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'event_class' => TextColumn::make('event_class')->searchable(),
            'properties' => TextColumn::make('properties')->limit(50),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
