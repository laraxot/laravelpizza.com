<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\SessionResource\Tables;

<<<<<<< HEAD
use Filament\Tables\Columns\Column;
=======
>>>>>>> 40b96bcd6 (.)
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SessionsTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'user_id' => TextColumn::make('user_id')->searchable()->sortable(),
            'ip_address' => TextColumn::make('ip_address')->searchable()->sortable(),
            'user_agent' => TextColumn::make('user_agent')->searchable()->sortable(),
            'last_activity' => TextColumn::make('last_activity')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
=======
    public function getTableColumns(): array
    {
        /*
         * @return array<int|string, \Filament\Tables\Columns\Column>
         */
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
