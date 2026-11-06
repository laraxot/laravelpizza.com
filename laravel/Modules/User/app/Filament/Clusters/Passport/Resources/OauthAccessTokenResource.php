<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Actions\Passport\RevokeAllUserTokensAction;
use Modules\User\Actions\Passport\RevokeTokenAction;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Models\OauthAccessToken;
use Modules\Xot\Filament\Resources\XotBaseResource;

use function Safe\json_encode;

class OauthAccessTokenResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    protected static ?string $model = OauthAccessToken::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IDColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->url(function (Model|array|null $record): ?string {
                        if (! $record instanceof OauthAccessToken) {
                            return null;
                        }
                        $user = $record->user;
                        if ($user !== null && method_exists($user, 'exists') && $user->exists) {
                            return UserResource::getUrl('view', ['record' => $user]);
                        }

                        return null;
                    })
                    ->openUrlInNewTab(),

                TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('scopes')
                    ->limit(30)
                    ->tooltip(
                        /** @param list<string>|string|null $state 'scopes' column state: the JSON-cast list, or one of its items. */
                        function (array|string|null $state): ?string {
                            return is_array($state) ? json_encode($state) : $state;
                        }
                    ),

                IconColumn::make('revoked')
                    ->boolean()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(function (Carbon|string|null $state): string {
                        if ($state instanceof Carbon) {
                            $now = Carbon::now();
                            if ($state->lt($now)) {
                                return $state->format('Y-m-d H:i:s').' (Expired)';
                            }

                            return $state->format('Y-m-d H:i:s');
                        }

                        return 'N/A';
                    }),
            ])
            ->filters([
                Filter::make('revoked')
                    ->query(fn (Builder $query) => $query->where('revoked', true)),

                Filter::make('expired')
                    ->query(fn (Builder $query) => $query->where('expires_at', '<', now())),

                Filter::make('valid')
                    ->query(fn (Builder $query) => $query->where('revoked', false)->where('expires_at', '>', now())),
            ])
            ->recordActions([
                Action::make('revoke')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Model|array|null $record): void {
                        if ($record instanceof Model) {
                            $key = $record->getKey();
                            if ((is_int($key) || is_string($key)) && app(RevokeTokenAction::class)->execute((string) $key)) {
                                Notification::make()
                                    ->title(static::trans('actions.revoke.success'))
                                    ->success()
                                    ->send();
                            }
                        }
                    })
                    ->visible(fn (Model|array|null $record) => $record instanceof OauthAccessToken && ! $record->revoked),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkAction::make('revoke_all_for_user')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Collection $records): void {
                        $users = $records->pluck('user_id')->unique();
                        $count = 0;
                        foreach ($users as $userId) {
                            if (is_string($userId) || is_int($userId)) {
                                $count += app(RevokeAllUserTokensAction::class)->execute((string) $userId);
                            }
                        }
                        Notification::make()
                            ->title(static::trans('actions.revoke_all_for_user.success', params: ['count' => $count]))
                            ->success()
                            ->send();
                    }),
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')
                ->searchable()
                ->sortable()
                ->copyable(),

            'user.name' => TextColumn::make('user.name')
                ->searchable()
                ->sortable()
                ->url(function (Model|array|null $record): ?string {
                    if (! $record instanceof OauthAccessToken) {
                        return null;
                    }
                    $user = $record->user;
                    if ($user !== null && method_exists($user, 'exists') && $user->exists) {
                        return UserResource::getUrl('view', ['record' => $user]);
                    }

                    return null;
                })
                ->openUrlInNewTab(),

            'client.name' => TextColumn::make('client.name')
                ->searchable()
                ->sortable(),

            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),

            'scopes' => TextColumn::make('scopes')
                ->limit(30)
                ->tooltip(
                    /** @param array<array-key, mixed>|scalar|null $state Raw 'scopes' column state. */
                    function (mixed $state): ?string {
                        if ($state === null) {
                            return null;
                        }
                        if (is_array($state)) {
                            return json_encode($state);
                        }

                        return is_string($state) ? $state : null;
                    }
                ),

            'revoked' => IconColumn::make('revoked')
                ->boolean()
                ->color(fn (bool $state): string => $state ? 'danger' : 'success'),

            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

            'expires_at' => TextColumn::make('expires_at')
                ->dateTime()
                ->sortable()
                ->formatStateUsing(function (Carbon|string|null $state): string {
                    if ($state instanceof Carbon) {
                        $now = Carbon::now();
                        if ($state->lt($now)) {
                            return $state->format('Y-m-d H:i:s').' (Expired)';
                        }

                        return $state->format('Y-m-d H:i:s');
                    }

                    return 'N/A';
                }),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    public static function getTableFilters(): array
    {
        return [
            'revoked' => Filter::make('revoked')
                ->query(fn (Builder $query) => $query->where('revoked', true)),

            'expired' => Filter::make('expired')
                ->query(fn (Builder $query) => $query->where('expires_at', '<', now())),

            'valid' => Filter::make('valid')
                ->query(fn (Builder $query) => $query->where('revoked', false)->where('expires_at', '>', now())),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public static function getTableActions(): array
    {
        return [
            'revoke' => Action::make('revoke')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (Model|array|null $record): void {
                    if ($record instanceof Model) {
                        $key = $record->getKey();
                        if ((is_int($key) || is_string($key)) && app(RevokeTokenAction::class)->execute((string) $key)) {
                            Notification::make()
                                ->title(static::trans('actions.revoke.success'))
                                ->success()
                                ->send();
                        }
                    }
                })
                ->visible(fn (Model|array|null $record): bool => $record instanceof OauthAccessToken && ! $record->revoked),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction|ActionGroup>
     */
    public static function getTableBulkActions(): array
    {
        return [
            'revoke_all_for_user' => BulkAction::make('revoke_all_for_user')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (Collection $records): void {
                    $users = $records->pluck('user_id')->unique();
                    $count = 0;
                    foreach ($users as $userId) {
                        if (is_string($userId) || is_int($userId)) {
                            $count += app(RevokeAllUserTokensAction::class)->execute((string) $userId);
                        }
                    }
                    Notification::make()
                        ->title(static::trans('actions.revoke_all_for_user.success', params: ['count' => $count]))
                        ->success()
                        ->send();
                }),
            'delete' => DeleteBulkAction::make(),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'client']);
    }
}
