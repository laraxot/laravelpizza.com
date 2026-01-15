<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\PasswordResetResource\Pages\ListPasswordResets;
use Modules\User\Filament\Resources\PasswordResetResource\Pages\ViewPasswordReset;
use Modules\User\Models\PasswordReset; // Added
use Modules\Xot\Filament\Resources\XotBaseResource;

class PasswordResetResource extends XotBaseResource
{
    protected static ?string $model = PasswordReset::class;

    public static function getPages(): array
    {
        return [
            'index' => ListPasswordResets::route('/'),
            'view' => ViewPasswordReset::route('/{record}'),
        ];
    }

    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'password_reset_info' => Section::make('Password Reset Information')
                ->schema([
                    'email' => TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    'token' => TextInput::make('token')
                        ->required()
                        ->maxLength(255),
                ]),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
