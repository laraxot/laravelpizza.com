<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Carbon;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

use function Safe\json_encode;

/**
 * Class OauthTokensRelationManager.
 */
class OauthTokensRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'tokens';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'client.name' => TextColumn::make('client.name')
                ->sortable(),
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'scopes' => TextColumn::make('scopes')
                ->limit(30)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
                    if ($state === null) {
                        return null;
                    }

                    if (is_array($state)) {
                        return json_encode($state);
                    }

                    return is_string($state) ? $state : null;
                }),
            'revoked' => IconColumn::make('revoked')
                ->boolean()
                ->color(fn (bool $state): string => $state ? 'danger' : 'success'),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            'expires_at' => TextColumn::make('expires_at')
                ->dateTime()
                ->sortable()
                ->formatStateUsing(function ($state) {
                    if ($state instanceof Carbon) {
                        $now = Carbon::now();
                        if ($state->lt($now)) {
                            return $state->format('Y-m-d H:i:s').' (Expired)';
                        }
                    }

                    return $state instanceof Carbon ? $state->format('Y-m-d H:i:s') : 'N/A';
                }),
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
