<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\Tenant;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TenantsTable extends XotBaseResourceTable
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
            'slug' => TextColumn::make('slug')->searchable()->sortable(),
            'domain' => TextColumn::make('domain')->searchable()->sortable(),
            'is_active' => IconColumn::make('is_active')->boolean()->sortable(),
            'trial_ends_at' => TextColumn::make('trial_ends_at')->dateTime()->sortable()->placeholder('—'),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
