<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ActivitysTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'log_name' => TextColumn::make('log_name')->searchable(),
            'description' => TextColumn::make('description')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
        ];
    }
}
