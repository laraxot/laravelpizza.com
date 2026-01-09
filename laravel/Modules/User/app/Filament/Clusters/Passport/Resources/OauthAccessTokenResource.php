<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages\EditOauthAccessTokens;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages\ListOauthAccessTokens;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource\Pages\ViewOauthAccessToken;
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
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->url(function (mixed $record): ?string {
                        if (! $record instanceof OauthAccessToken) {
                            return null;
                        }
                        $user = $record->user;
                        if (null !== $user && method_exists($user, 'exists') && $user->exists) {
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

                IconColumn::make('revoked')
                    ->boolean()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('expires_at')
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
