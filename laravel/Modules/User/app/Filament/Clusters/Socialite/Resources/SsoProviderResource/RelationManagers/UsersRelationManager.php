<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource\RelationManagers;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * Users Relation Manager for SSO Provider Resource.
 */
class UsersRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable()->toggleable(),
            'name' => TextColumn::make('name')->searchable()->sortable()->toggleable(),
            'email' => TextColumn::make('email')->searchable()->sortable()->toggleable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
