<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class UsersTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'first_name' => TextColumn::make('first_name')->searchable(),
            'last_name' => TextColumn::make('last_name')->searchable(),
            'email' => TextColumn::make('email')->searchable(),
            'email_verified_at' => TextColumn::make('email_verified_at')->dateTime(),
            'is_active' => TextColumn::make('is_active')->badge(),
            'is_otp' => TextColumn::make('is_otp')->badge(),
            'lang' => TextColumn::make('lang'),
            'current_team_id' => TextColumn::make('current_team_id'),
            'type' => TextColumn::make('type'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
