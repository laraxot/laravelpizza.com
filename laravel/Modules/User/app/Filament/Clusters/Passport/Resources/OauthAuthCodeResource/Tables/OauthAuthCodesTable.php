<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\OauthAuthCode;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OauthAuthCodesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<OauthAuthCode>
     */
    protected static string $model = OauthAuthCode::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'user_id' => TextColumn::make('user_id')->sortable(),
            'client_id' => TextColumn::make('client_id')->sortable()->copyable(),
            'revoked' => IconColumn::make('revoked')->boolean()->sortable(),
            'expires_at' => TextColumn::make('expires_at')->dateTime()->sortable()->placeholder('—'),
            'scopes' => TextColumn::make('scopes')->badge()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
