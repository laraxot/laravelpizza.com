<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Tables;

<<<<<<< HEAD
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
=======
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ActivitiesTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'log_name' => TextColumn::make('log_name')->searchable(),
            'description' => TextColumn::make('description')->searchable(),
            'event' => TextColumn::make('event')->searchable(),
            'subject_type' => TextColumn::make('subject_type')->searchable(),
            'subject_id' => TextColumn::make('subject_id')->searchable(),
            'causer_type' => TextColumn::make('causer_type')->searchable(),
            'causer_id' => TextColumn::make('causer_id')->searchable(),
            'properties' => TextColumn::make('properties')->limit(50),
            'batch_uuid' => TextColumn::make('batch_uuid')->limit(30),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
