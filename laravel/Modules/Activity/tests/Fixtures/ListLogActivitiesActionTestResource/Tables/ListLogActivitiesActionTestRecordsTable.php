<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

final class ListLogActivitiesActionTestRecordsTable extends XotBaseResourceTable
{
    /** @return array<string, Column> */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
        ];
    }
}
