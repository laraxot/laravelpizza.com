<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PasswordResetResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class PasswordResetForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
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
}
