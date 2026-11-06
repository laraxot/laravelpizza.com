<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TenantUserResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\TenantUser;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TenantUsersTable extends XotBaseResourceTable
{
    /**
     * @var class-string<TenantUser>
     */
    protected static string $model = TenantUser::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'user_id' => TextColumn::make('user_id')->sortable(),
            'tenant_id' => TextColumn::make('tenant_id')->sortable(),
            'role' => TextColumn::make('role'),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'uuid' => TextColumn::make('uuid')->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
            'deleted_at' => TextColumn::make('deleted_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
