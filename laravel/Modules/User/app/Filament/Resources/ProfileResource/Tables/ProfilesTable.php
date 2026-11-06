<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ProfileResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\Profile;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ProfilesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Profile>
     */
    protected static string $model = Profile::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'first_name' => TextColumn::make('first_name')->searchable()->sortable(),
            'last_name' => TextColumn::make('last_name')->searchable()->sortable(),
            'email' => TextColumn::make('email')->searchable()->sortable()->copyable(),
            'phone' => TextColumn::make('phone')->searchable(),
            'status' => TextColumn::make('status'),
            'is_active' => IconColumn::make('is_active')->boolean()->sortable(),
            'user_id' => TextColumn::make('user_id')->sortable(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'uuid' => TextColumn::make('uuid')->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
