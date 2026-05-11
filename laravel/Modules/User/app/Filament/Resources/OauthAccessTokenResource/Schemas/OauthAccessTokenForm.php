<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAccessTokenResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OauthAccessTokenForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
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
}
