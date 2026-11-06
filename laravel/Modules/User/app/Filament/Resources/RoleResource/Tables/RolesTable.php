<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\Role;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class RolesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Role>
     */
    protected static string $model = Role::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'display_name' => TextColumn::make('display_name')->searchable()->sortable(),
            'guard_name' => TextColumn::make('guard_name')->badge()->sortable(),
            'description' => TextColumn::make('description')->limit(60)->wrap()->toggleable(isToggledHiddenByDefault: true),
            'team_id' => TextColumn::make('team_id')->sortable(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'guard_name' => SelectFilter::make('guard_name')
                ->options([
                    'web' => 'Web',
                    'api' => 'API',
                    'sanctum' => 'Sanctum',
                ])
                ->multiple(),
        ];
    }
}
