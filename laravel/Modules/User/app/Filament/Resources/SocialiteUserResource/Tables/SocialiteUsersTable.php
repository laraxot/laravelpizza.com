<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialiteUserResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SocialiteUsersTable extends XotBaseResourceTable
{
    /**
     * @var class-string<SocialiteUser>
     */
    protected static string $model = SocialiteUser::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'email' => TextColumn::make('email')->searchable()->sortable()->copyable(),
            'provider' => TextColumn::make('provider')->searchable()->sortable(),
            'provider_id' => TextColumn::make('provider_id')->searchable()->sortable(),
            'user_id' => TextColumn::make('user_id')->sortable(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
