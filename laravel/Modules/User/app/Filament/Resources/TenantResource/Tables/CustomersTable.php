<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\Tenant;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CustomersTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Tenant>
     */
    protected static string $model = Tenant::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'email' => TextColumn::make('email')->searchable()->sortable()->copyable(),
            'mobile_phone' => TextColumn::make('mobile_phone'),
            'slug' => TextColumn::make('slug')->searchable()->sortable(),
            'team_id' => TextColumn::make('team_id')->sortable(),
            'user_id' => TextColumn::make('user_id')->sortable(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
