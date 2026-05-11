<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedJobResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * FailedJobsTable Schema.
 */
class FailedJobsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('connection')->searchable()->sortable(),
            TextColumn::make('queue')->searchable()->sortable(),
            TextColumn::make('failed_at')->dateTime()->sortable(),
        ];
    }
}
