<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\Client;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * OAuth Client Resource.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseResource, MAI Filament\Resources\Resource
 * direttamente! Segue il pattern DRY: solo getFormSchema() necessario,
 * table() e metodi table* gestiti automaticamente.
 */
class OauthClientResource extends XotBaseResource
{
    protected static ?string $model = Client::class;

    /**
     * Schema del form per la risorsa.
     *
     * @return array<string, Field>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255),
            'user_id' => Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable(),
            'redirect' => TextInput::make('redirect')
                ->maxLength(2000),
            'secret' => TextInput::make('secret')
                ->password()
                ->maxLength(100),
            'provider' => Select::make('provider')
                ->options([
                    'users' => 'Users',
                ]),
            'personal_access_client' => TextInput::make('personal_access_client')
                ->numeric(),
            'password_client' => TextInput::make('password_client')
                ->numeric(),
        ];
    }

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }
}
