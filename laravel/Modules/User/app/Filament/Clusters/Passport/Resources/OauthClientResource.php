<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\Client;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages\CreateOauthClient;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages\EditOauthClient;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages\ListOauthClients;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages\ViewOauthClient;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * Class OauthClientResource.
 */
class OauthClientResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    protected static ?string $model = Client::class;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Schema del form per la risorsa.
     *
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'oauth_client' => Section::make()
                ->schema([
                    'grid_1' => Grid::make(2)
                        ->schema([
                            'name' => TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            'user_id' => Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable(),
                        ]),
                    'grid_2' => Grid::make(2)
                        ->schema([
                            'redirect' => TextInput::make('redirect')
                                ->maxLength(2000),
                            'secret' => TextInput::make('secret')
                                ->password()
                                ->maxLength(100),
                        ]),
                    'grid_3' => Grid::make(3)
                        ->schema([
                            'provider' => Select::make('provider')
                                ->options([
                                    'users' => 'users',
                                ]),
                            'personal_access_client' => TextInput::make('personal_access_client')
                                ->numeric(),
                            'password_client' => TextInput::make('password_client')
                                ->numeric(),
                        ]),
                ]),
        ];
    }

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOauthClients::route('/'),
            'create' => CreateOauthClient::route('/create'),
            'edit' => EditOauthClient::route('/{record}/edit'),
            'view' => ViewOauthClient::route('/{record}'),
        ];
    }
}
