<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
<<<<<<< .merge_file_CNaw6Q
use Modules\Activity\Models\Activity;
=======
use Modules\UI\Filament\Tables\Columns\IDColumn;
>>>>>>> .merge_file_Y3yRGI
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\json_encode;

class ActivitiesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Activity>
     */
    protected static string $model = Activity::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
<<<<<<< .merge_file_CNaw6Q
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'log_name' => TextColumn::make('log_name')->searchable()->sortable(),
            'description' => TextColumn::make('description')->searchable()->wrap()->limit(100),
            'event' => TextColumn::make('event')->searchable()->sortable(),
            'subject_type' => TextColumn::make('subject_type')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'subject_id' => TextColumn::make('subject_id')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'causer_type' => TextColumn::make('causer_type')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'causer_id' => TextColumn::make('causer_id')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'batch_uuid' => TextColumn::make('batch_uuid')->limit(30)->copyable()->toggleable(isToggledHiddenByDefault: true),
            'properties' => TextColumn::make('properties')
                ->state(static fn (Activity $record): string => json_encode($record->properties, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->limit(100)
                ->wrap()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable(),
=======
            'id' => IDColumn::make('id')->searchable()->sortable(),
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
>>>>>>> .merge_file_Y3yRGI
        ];
    }
}
