<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthPersonalAccessClientResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\OauthPersonalAccessClient;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OauthPersonalAccessClientsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<OauthPersonalAccessClient>
     */
    protected static string $model = OauthPersonalAccessClient::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'client_id' => TextColumn::make('client_id')->sortable()->copyable(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
