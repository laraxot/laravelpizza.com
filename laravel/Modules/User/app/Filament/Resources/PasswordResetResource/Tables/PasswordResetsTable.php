<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PasswordResetResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PasswordResetsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'email' => TextColumn::make('email')->searchable(),
            'token' => TextColumn::make('token'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
