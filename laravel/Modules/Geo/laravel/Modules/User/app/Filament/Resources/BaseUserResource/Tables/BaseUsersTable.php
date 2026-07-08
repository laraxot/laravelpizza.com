<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseUserResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class BaseUsersTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        /*
         * @return array<int|string, \Filament\Tables\Columns\Column>
         */
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'first_name' => TextColumn::make('first_name')->searchable(),
            'last_name' => TextColumn::make('last_name')->searchable(),
            'email' => TextColumn::make('email')->searchable()->sortable(),
            'lang' => TextColumn::make('lang')->searchable(),
            'current_team_id' => TextColumn::make('current_team_id')->searchable(),
            'is_active' => IconColumn::make('is_active')->boolean(),
            'is_otp' => IconColumn::make('is_otp')->boolean(),
            'password_expires_at' => TextColumn::make('password_expires_at')->dateTime(),
            'email_verified_at' => TextColumn::make('email_verified_at')->dateTime(),
            'type' => TextColumn::make('type')->searchable(),
            'state' => TextColumn::make('state')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }
}
