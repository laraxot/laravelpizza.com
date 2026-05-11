<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthRefreshTokenResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OauthRefreshTokenForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'access_token_id' => Select::make('access_token_id')
                ->relationship('accessToken', 'id')
                ->searchable()
                ->required(),
            'revoked' => TextInput::make('revoked')
                ->numeric()
                ->required(),
            'expires_at' => TextInput::make('expires_at'),
        ];
    }
}
