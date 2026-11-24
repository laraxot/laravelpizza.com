<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Activity\Models\Activity;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\json_encode;

/**
 * Colonne della lista Activity: audit trail completo (subject/causer/properties) senza label hardcoded.
 */
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
            'id' => IDColumn::make('id')->searchable()->sortable(),
            'log_name' => TextColumn::make('log_name')->searchable()->sortable(),
            'description' => TextColumn::make('description')->searchable()->wrap()->limit(100),
            'event' => TextColumn::make('event')->searchable()->sortable(),
            'subject_type' => TextColumn::make('subject_type')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'subject_id' => TextColumn::make('subject_id')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'causer_type' => TextColumn::make('causer_type')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'causer_id' => TextColumn::make('causer_id')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'properties' => TextColumn::make('properties')
                ->state(static fn (Activity $record): string => json_encode(
                    $record->properties,
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ))
                ->limit(100)
                ->wrap()
                ->toggleable(isToggledHiddenByDefault: true),
            'batch_uuid' => TextColumn::make('batch_uuid')->limit(30)->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable(),
        ];
    }
}
