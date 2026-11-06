<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthDeviceCodeResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\User\Models\OauthDeviceCode;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OauthDeviceCodesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<OauthDeviceCode>
     */
    protected static string $model = OauthDeviceCode::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'user_id' => TextColumn::make('user_id')->sortable(),
            'client_id' => TextColumn::make('client_id')->sortable()->copyable(),
            'revoked' => IconColumn::make('revoked')->boolean()->sortable(),
            'user_approved_at' => TextColumn::make('user_approved_at')->dateTime()->sortable()->placeholder('—'),
            'expires_at' => TextColumn::make('expires_at')->dateTime()->sortable()->placeholder('—'),
            'last_polled_at' => TextColumn::make('last_polled_at')->dateTime()->sortable()->placeholder('—'),
            'scopes' => TextColumn::make('scopes')->badge()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
