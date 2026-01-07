<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * Class SocialiteUsersRelationManager.
 */
class SocialiteUsersRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'socialiteUsers';

    protected static ?string $recordTitleAttribute = 'provider';

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'provider' => TextColumn::make('provider')
                ->sortable()
                ->searchable(),
            'provider_id' => TextColumn::make('provider_id')
                ->searchable(),
            'provider_avatar' => TextColumn::make('provider_avatar')
                ->formatStateUsing(function (mixed $state): string {
                    if ($state) {
                        /** @phpstan-var view-string $viewString */
                        $viewString = 'filament.components.avatar';

                        return view($viewString, ['url' => (string) $state])->render();
                    }

                    return 'No Avatar';
                })
                ->html(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
