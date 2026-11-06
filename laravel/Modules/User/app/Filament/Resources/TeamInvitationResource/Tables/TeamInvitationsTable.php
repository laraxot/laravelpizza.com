<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamInvitationResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\TeamInvitation;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TeamInvitationsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<TeamInvitation>
     */
    protected static string $model = TeamInvitation::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'email' => TextColumn::make('email')->searchable()->sortable()->copyable(),
            'team_id' => TextColumn::make('team_id')->sortable(),
            'role' => TextColumn::make('role')->badge()->sortable(),
            'accepted_at' => TextColumn::make('accepted_at')->dateTime()->sortable()->placeholder('—'),
            'declined_at' => TextColumn::make('declined_at')->dateTime()->sortable()->placeholder('—'),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
            'deleted_at' => TextColumn::make('deleted_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
