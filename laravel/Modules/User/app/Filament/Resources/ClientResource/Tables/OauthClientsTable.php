<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\OauthClient;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OauthClientsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<OauthClient>
     */
    protected static string $model = OauthClient::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'provider' => TextColumn::make('provider')->searchable()->sortable(),
            'grant_types' => TextColumn::make('grant_types')->badge(),
            'redirect_uris' => TextColumn::make('redirect_uris')->limit(60)->wrap(),
            'revoked' => IconColumn::make('revoked')->boolean()->sortable(),
            'owner_id' => TextColumn::make('owner_id')->sortable()->toggleable(isToggledHiddenByDefault: true),
            'owner_type' => TextColumn::make('owner_type')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
