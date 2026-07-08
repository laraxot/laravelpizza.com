<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ClientForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
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
}
