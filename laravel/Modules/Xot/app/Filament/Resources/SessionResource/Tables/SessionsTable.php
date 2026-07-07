<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\SessionResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SessionsTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        /*
         * @return array<int|string, \Filament\Tables\Columns\Column>
         */
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }
}
