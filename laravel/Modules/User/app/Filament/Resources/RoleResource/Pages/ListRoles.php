<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\User\Filament\Resources\RoleResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListRoles extends XotBaseListRecords
{
    protected static string $resource = RoleResource::class;

    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            // Tables\Columns\TextColumn::make('role'),
            'guard_name' => TextColumn::make('guard_name')->searchable()->sortable(),
            'team_id' => TextColumn::make('team.name')->searchable()->sortable(),
        ];
    }

    #[\Override]
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
