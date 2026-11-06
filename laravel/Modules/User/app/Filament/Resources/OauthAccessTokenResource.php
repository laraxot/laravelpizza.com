<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Filament\Resources\OauthAccessTokenResource\Pages\ListOauthAccessTokens;
use Modules\User\Filament\Resources\OauthAccessTokenResource\Pages\ViewOauthAccessToken;
use Modules\User\Models\OauthAccessToken;
use Modules\Xot\Filament\Resources\XotBaseResource;

use function Safe\json_encode;

class OauthAccessTokenResource extends XotBaseResource
{
    protected static ?string $model = OauthAccessToken::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return __('OAuth Access Tokens');
    }

    public static function getPluralLabel(): string
    {
        return __('OAuth Access Tokens');
    }

    public static function getModelLabel(): string
    {
        return __('OAuth Access Token');
    }

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
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOauthAccessTokens::route('/'),
            'view' => ViewOauthAccessToken::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'client']);
    }
}
