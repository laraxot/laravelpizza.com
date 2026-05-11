<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AuthenticationLogsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'authenticatable_id' => TextColumn::make('authenticatable_id'),
            'ip_address' => TextColumn::make('ip_address'),
            'user_agent' => TextColumn::make('user_agent'),
            'login_at' => TextColumn::make('login_at')->dateTime(),
            'login_successful' => TextColumn::make('login_successful')->badge(),
            'logout_at' => TextColumn::make('logout_at')->dateTime(),
            'cleared_by_user' => TextColumn::make('cleared_by_user')->badge(),
            'location' => TextColumn::make('location'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            'updated_by' => TextColumn::make('updated_by')->toggleable(),
            'created_by' => TextColumn::make('created_by')->toggleable(),
        ];
    }
}
