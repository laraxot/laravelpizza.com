<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class AuthenticationLogForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'authentication_info_section' => Section::make('Authentication Information')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('authenticatable_type')
                                ->options([
                                    User::class => 'User',
                                    // Add other authenticatable types as needed
                                ])
                                ->required()
                                ->searchable(),

                            TextInput::make('authenticatable_id')
                                ->required()
                                ->numeric(),
                        ]),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('ip_address')
                                ->maxLength(45),

                            TextInput::make('user_agent')
                                ->maxLength(500),
                        ]),

                    Grid::make(3)
                        ->schema([
                            Toggle::make('login_successful')
                                ->inline(false),

                            TextInput::make('login_at'),

                            TextInput::make('logout_at'),
                        ]),

                    Toggle::make('cleared_by_user')
                        ->inline(false),
                ]),
        ];
    }
}
