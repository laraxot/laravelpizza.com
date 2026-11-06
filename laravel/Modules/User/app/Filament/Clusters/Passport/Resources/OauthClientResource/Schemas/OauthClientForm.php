<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Schemas;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OauthClientForm extends XotBaseResourceForm
{
    /**
     * Get the form schema for the resource (XotBaseResource pattern).
     *
     * @return array<string, Field>
     */
    /**
     * @return array<string, Field>
     */
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->unique('oauth_clients', 'name')
                ->required()
                ->maxLength(255),
            'user_id' => Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable(),
            'redirect' => TextInput::make('redirect')
                ->url()
                ->maxLength(2000),
            'provider' => TextInput::make('provider')
                ->maxLength(255),
        ];
    }
}
