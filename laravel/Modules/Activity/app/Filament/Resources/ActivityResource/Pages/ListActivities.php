<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * @see ActivityResource
 */
class ListActivities extends XotBaseListRecords
{
    protected static string $resource = ActivityResource::class;

    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            'description' => TextColumn::make('description')
                ->searchable()
                ->limit(50),
            'subject_type' => TextColumn::make('subject_type')
                ->searchable(),
            'subject_id' => TextColumn::make('subject_id')
                ->searchable(),
            'causer_type' => TextColumn::make('causer_type')
                ->searchable(),
            'causer_id' => TextColumn::make('causer_id')
                ->searchable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
