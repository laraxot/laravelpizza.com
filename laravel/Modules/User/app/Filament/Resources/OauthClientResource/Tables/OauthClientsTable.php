<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OauthClientsTable extends XotBaseResourceTable
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
            'user_id' => TextColumn::make('user_id'),
            'name' => TextColumn::make('name')->searchable(),
            'provider' => TextColumn::make('provider'),
            'redirect' => TextColumn::make('redirect'),
            'personal_access_client' => TextColumn::make('personal_access_client')->badge(),
            'password_client' => TextColumn::make('password_client')->badge(),
            'revoked' => TextColumn::make('revoked')->badge(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
