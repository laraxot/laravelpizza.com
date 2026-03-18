<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\User\Actions\Passport\RevokeTokenAction;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\User\Models\OauthToken;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

use function Safe\json_encode;

/**
 * Relation manager per i token OAuth del client.
 */
class TokensRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'tokens';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Token OAuth';

    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'scopes' => TextColumn::make('scopes')
                ->limit(30)
                ->tooltip(function (mixed $state): ?string {
                    if (null === $state) {
                        return null;
                    }
                    if (is_array($state)) {
                        return json_encode($state);
                    }

                    return is_string($state) ? $state : null;
                })
                ->formatStateUsing(function (mixed $state): string {
                    if (is_array($state)) {
                        return implode(', ', array_map(fn (mixed $s): string => (string) $s, $state));
                    }

                    return (string) ($state ?? '');
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
                ->formatStateUsing(function (mixed $state): string {
                    if ($state instanceof Carbon) {
                        $now = Carbon::now();
                        if ($state->lt($now)) {
                            return $state->format('Y-m-d H:i').' (Scaduto)';
                        }

                        return $state->format('Y-m-d H:i');
                    }

                    return 'N/A';
                }),
        ];
    }

    /**
     * @return array<string, Filter>
     */
    #[\Override]
    public function getTableFilters(): array
    {
        return [
            'revoked' => Filter::make('revoked')
                ->label('Revocati')
                ->query(fn (Builder $query) => $query->where('revoked', true)),
            'expired' => Filter::make('expired')
                ->label('Scaduti')
                ->query(fn (Builder $query) => $query->where('expires_at', '<', now())),
            'valid' => Filter::make('valid')
                ->label('Validi')
                ->query(fn (Builder $query) => $query->where('revoked', false)->where('expires_at', '>', now())),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableActions(): array
    {
        return [
            'view' => Action::make('view')
                ->label('Visualizza')
                ->icon('heroicon-o-eye')
                ->url(fn (OauthToken $record): string => OauthAccessTokenResource::getUrl('view', ['record' => $record])),
            'revoke' => Action::make('revoke')
                ->label('Revoca')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (OauthToken $record) {
                    if (app(RevokeTokenAction::class)->execute($record)) {
                        Notification::make()
                            ->title('Token revocato')
                            ->success()
                            ->send();
                    }
                })
                ->visible(fn (OauthToken $record): bool => ! $record->revoked),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableHeaderActions(): array
    {
        return [];
    }
}
