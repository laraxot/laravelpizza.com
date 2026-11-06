<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAccessTokenResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\OauthAccessToken;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OauthAccessTokensTable extends XotBaseResourceTable
{
    /**
     * @var class-string<OauthAccessToken>
     */
    protected static string $model = OauthAccessToken::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'user_id' => TextColumn::make('user_id')->sortable(),
            'client_id' => TextColumn::make('client_id')->sortable()->copyable(),
            'revoked' => IconColumn::make('revoked')->boolean()->sortable(),
            'expires_at' => TextColumn::make('expires_at')->dateTime()->sortable()->placeholder('—'),
            'scopes' => TextColumn::make('scopes')->badge()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
