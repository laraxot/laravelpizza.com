<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthRefreshTokenResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OauthRefreshTokensTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'access_token_id' => TextColumn::make('access_token_id'),
            'revoked' => TextColumn::make('revoked')->badge(),
            'expires_at' => TextColumn::make('expires_at')->dateTime(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
