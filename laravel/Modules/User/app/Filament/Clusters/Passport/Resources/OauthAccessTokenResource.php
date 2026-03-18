<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
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
use Modules\User\Actions\Passport\RevokeAllUserTokensAction;
use Modules\User\Actions\Passport\RevokeTokenAction;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages\EditOauthAccessTokens;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages\ListOauthAccessTokens;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages\ViewOauthAccessToken;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Models\OauthToken;
use Modules\Xot\Filament\Resources\XotBaseResource;

use function Safe\json_encode;

class OauthAccessTokenResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    /** @phpstan-ignore-next-line Passport wrapper model is valid at runtime, but PHPStan does not fully infer the upstream subtype here. */
    protected static ?string $model = OauthToken::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->filters(static::getTableFilters())
            ->actions(static::getTableActions())
            ->bulkActions(static::getTableBulkActions())
            ->defaultSort('created_at', 'desc');
    }

    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->searchable()
                ->sortable()
                ->copyable(),

            'user.name' => TextColumn::make('user.name')
                ->searchable()
                ->sortable()
                ->url(function (mixed $record): ?string {
                    if (! $record instanceof OauthToken) {
                        return null;
                    }
                    $user = $record->user;
                    if (null !== $user && method_exists($user, 'exists') && $user->exists) {
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
                ->tooltip(function (mixed $state): ?string {
                    if (null === $state) {
                        return null;
                    }
                    if (is_array($state)) {
                        /* @var array<string, mixed> $state */
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
                ->formatStateUsing(function (mixed $state): string {
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
                ->action(function (mixed $record) {
                    if ($record instanceof Model) {
                        if (app(RevokeTokenAction::class)->execute((string) $record->getKey())) {
                            Notification::make()
                                ->title(static::trans('actions.revoke.success'))
                                ->success()
                                ->send();
                        }
                    }
                })
                ->visible(fn (mixed $record) => $record instanceof OauthToken && ! $record->revoked),
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
                ->action(function (Collection $records) {
                    $users = $records->pluck('user_id')->unique();
                    $count = 0;
                    foreach ($users as $userId) {
                        if (is_string($userId) || is_int($userId)) {
                            $count += app(RevokeAllUserTokensAction::class)->execute((string) $userId);
                        }
                    }
                    Notification::make()
                        ->title(static::trans('actions.revoke_all_for_user.success'))
                        ->success()
                        ->send();
                }),
            'delete' => DeleteBulkAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOauthAccessTokens::route('/'),
            'view' => ViewOauthAccessToken::route('/{record}'),
            'edit' => EditOauthAccessTokens::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'oauth_access_token_info' => Section::make('OAuth Access Token Information')
                ->schema([
                    'grid_1' => Grid::make(2)
                        ->schema([
                            'user_id' => Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable(),
                            'client_id' => Select::make('client_id')
                                ->relationship('client', 'name')
                                ->searchable()
                                ->required(),
                        ]),

                    'grid_2' => Grid::make(2)
                        ->schema([
                            'name' => TextInput::make('name')
                                ->maxLength(255),
                            'scopes' => TextInput::make('scopes'),
                        ]),
                ]),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'client']);
    }
}
