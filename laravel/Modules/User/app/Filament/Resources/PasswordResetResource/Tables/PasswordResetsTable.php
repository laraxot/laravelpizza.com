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
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'email' => TextColumn::make('email')->searchable(),
            'token' => TextColumn::make('token'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
