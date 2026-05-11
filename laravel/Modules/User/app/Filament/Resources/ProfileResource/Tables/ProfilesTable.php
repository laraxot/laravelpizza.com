<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ProfileResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ProfilesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'user_id' => TextColumn::make('user_id'),
            'first_name' => TextColumn::make('first_name')->searchable(),
            'last_name' => TextColumn::make('last_name')->searchable(),
            'email' => TextColumn::make('email')->searchable(),
            'phone' => TextColumn::make('phone'),
            'status' => TextColumn::make('status'),
            'is_active' => TextColumn::make('is_active')->badge(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
