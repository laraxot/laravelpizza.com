<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamPermissionResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\TeamPermission;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TeamPermissionsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<TeamPermission>
     */
    protected static string $model = TeamPermission::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'permission' => TextColumn::make('permission')->searchable()->sortable(),
            'team_id' => TextColumn::make('team_id')->sortable(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
            'deleted_at' => TextColumn::make('deleted_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
