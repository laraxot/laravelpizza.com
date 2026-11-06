<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamUserResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\TeamUser;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TeamUsersTable extends XotBaseResourceTable
{
    /**
     * @var class-string<TeamUser>
     */
    protected static string $model = TeamUser::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'user_id' => TextColumn::make('user_id')->sortable(),
            'team_id' => TextColumn::make('team_id')->sortable(),
            'role' => TextColumn::make('role')->badge()->sortable(),
            'joined_at' => TextColumn::make('joined_at')->dateTime()->sortable()->placeholder('—'),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'uuid' => TextColumn::make('uuid')->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
