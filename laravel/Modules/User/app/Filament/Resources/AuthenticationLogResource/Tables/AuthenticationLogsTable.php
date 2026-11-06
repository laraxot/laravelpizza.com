<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\AuthenticationLog;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AuthenticationLogsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<AuthenticationLog>
     */
    protected static string $model = AuthenticationLog::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'authenticatable_id' => TextColumn::make('authenticatable_id')->sortable()->copyable(),
            'ip_address' => TextColumn::make('ip_address')->searchable()->sortable(),
            'login_at' => TextColumn::make('login_at')->dateTime()->sortable()->placeholder('—'),
            'login_successful' => IconColumn::make('login_successful')->boolean()->sortable(),
            'logout_at' => TextColumn::make('logout_at')->dateTime()->sortable()->placeholder('—'),
            'cleared_by_user' => IconColumn::make('cleared_by_user')->boolean()->sortable(),
            'user_agent' => TextColumn::make('user_agent')->limit(60)->wrap()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
