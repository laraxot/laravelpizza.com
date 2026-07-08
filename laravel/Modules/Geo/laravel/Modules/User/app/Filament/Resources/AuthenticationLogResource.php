<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\AuthenticationLogResource\Pages\ListAuthenticationLogs;
use Modules\User\Filament\Resources\AuthenticationLogResource\Pages\ViewAuthenticationLog;
use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AuthenticationLogResource extends XotBaseResource
{
    protected static ?string $model = AuthenticationLog::class;

    public static function getPages(): array
    {
        return [
            'index' => ListAuthenticationLogs::route('/'),
            'view' => ViewAuthenticationLog::route('/{record}'),
        ];
    }

    /**
     * @return array<string, Component>
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['authenticatable']);
    }
}
