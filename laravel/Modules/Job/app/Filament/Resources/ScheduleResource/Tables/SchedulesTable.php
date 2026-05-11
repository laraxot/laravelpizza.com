<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\ScheduleResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SchedulesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'command' => TextColumn::make('command')->searchable()->sortable(),
            'expression' => TextColumn::make('expression')->sortable(),
            'status' => TextColumn::make('status')->badge()->sortable(),
            'even_in_maintenance_mode' => TextColumn::make('even_in_maintenance_mode')->badge()->sortable(),
            'without_overlapping' => TextColumn::make('without_overlapping')->badge()->sortable(),
            'on_one_server' => TextColumn::make('on_one_server')->badge()->sortable(),
            'run_in_background' => TextColumn::make('run_in_background')->badge()->sortable(),
            'log_filename' => TextColumn::make('log_filename')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
