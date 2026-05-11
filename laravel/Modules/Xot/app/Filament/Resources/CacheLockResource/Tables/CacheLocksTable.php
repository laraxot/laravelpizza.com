<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\CacheLockResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CacheLocksTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'key' => TextColumn::make('key')->searchable()->sortable(),
            'owner' => TextColumn::make('owner')->searchable()->sortable(),
            'expiration' => TextColumn::make('expiration')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
