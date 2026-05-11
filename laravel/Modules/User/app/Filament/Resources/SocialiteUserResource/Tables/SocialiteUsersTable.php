<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialiteUserResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SocialiteUsersTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'user_id' => TextColumn::make('user_id'),
            'provider' => TextColumn::make('provider'),
            'provider_id' => TextColumn::make('provider_id'),
            'name' => TextColumn::make('name'),
            'nickname' => TextColumn::make('nickname'),
            'email' => TextColumn::make('email')->searchable(),
            'avatar' => TextColumn::make('avatar'),
            'token' => TextColumn::make('token'),
            'refresh_token' => TextColumn::make('refresh_token'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
