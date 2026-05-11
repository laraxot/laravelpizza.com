<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAuthCodeResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OauthAuthCodeForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'user_id' => Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable(),
            'client_id' => Select::make('client_id')
                ->relationship('client', 'name')
                ->searchable()
                ->required(),
            'scopes' => TextInput::make('scopes'),
            'revoked' => TextInput::make('revoked')
                ->numeric()
                ->required(),
        ];
    }
}
