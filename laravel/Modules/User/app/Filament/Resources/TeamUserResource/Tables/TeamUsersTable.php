<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamUserResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TeamUsersTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'role' => TextColumn::make('role'),
            'team_id' => TextColumn::make('team_id'),
            'user_id' => TextColumn::make('user_id'),
            'customer_id' => TextColumn::make('customer_id'),
            'joined_at' => TextColumn::make('joined_at')->dateTime(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }
}
