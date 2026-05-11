<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class JobsWaitingsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'queue' => TextColumn::make('queue')->searchable()->sortable(),
            'attempts' => TextColumn::make('attempts')->sortable(),
            'available_at' => TextColumn::make('available_at')->sortable(),
            'reserved_at' => TextColumn::make('reserved_at')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
