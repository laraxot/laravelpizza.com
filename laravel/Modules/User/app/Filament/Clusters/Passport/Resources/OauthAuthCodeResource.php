<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource\Pages\ListOauthAuthCodes;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAuthCodeResource\Pages\ViewOauthAuthCode;
use Modules\User\Models\OauthAuthCode;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class OauthAuthCodeResource.
 */
class OauthAuthCodeResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    protected static ?string $model = OauthAuthCode::class;

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'oauth_auth_code_info' => Section::make(static::trans('label'))
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
                            'scopes' => TextInput::make('scopes'),
                            'revoked' => TextInput::make('revoked')
                                ->numeric()
                                ->required(),
                            'expires_at' => TextInput::make('expires_at'),
                        ]),
                ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                \Filament\Tables\Columns\TextColumn::make('user_id')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('client_id')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('scopes')
                    ->limit(30),

                \Filament\Tables\Columns\IconColumn::make('revoked')
                    ->boolean()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),

                \Filament\Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('revoke')
                    ->label(static::trans('actions.revoke.label'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(static::trans('actions.revoke.label'))
                    ->action(function (mixed $record) {
                        if ($record instanceof OauthAuthCode) {
                            $record->revoked = true;
                            $record->save();
                            Notification::make()
                                ->title(static::trans('actions.revoke.success'))
                                ->success()
                                ->send();
                        }
                    })
                    ->visible(fn (mixed $record) => $record instanceof OauthAuthCode && ! $record->revoked),
                \Filament\Actions\DeleteAction::make(),
            ]);
    }

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOauthAuthCodes::route('/'),
            'view' => ViewOauthAuthCode::route('/{record}'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'client']);
    }
}
