<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * Class SocialiteUsersRelationManager.
 */
class SocialiteUsersRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'socialiteUsers';

    protected static ?string $recordTitleAttribute = 'provider';

    protected static string|BackedEnum|null $icon = 'heroicon-o-globe-alt';

    protected static bool $isBadgeDeferred = true;

    /**
     * Badge di conteggio (deferred: caricato via AJAX, non blocca il render iniziale
     * della tab con una query extra sincrona).
     */
    #[\Override]
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        if (! $ownerRecord instanceof User) {
            return null;
        }

        return (string) $ownerRecord->socialiteUsers()->count();
    }

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
                ->formatStateUsing(function (string|int|float|bool|null $state): string {
                    if (\is_scalar($state) && $state) {
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
