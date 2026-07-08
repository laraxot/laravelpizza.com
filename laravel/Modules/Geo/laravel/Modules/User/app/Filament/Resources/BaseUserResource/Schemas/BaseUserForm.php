<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseUserResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class BaseUserForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')->required(),
            'first_name' => TextInput::make('first_name'),
            'last_name' => TextInput::make('last_name'),
            'email' => TextInput::make('email')->email()->required(),
            'password' => TextInput::make('password')->password(),
            'lang' => TextInput::make('lang'),
            'current_team_id' => TextInput::make('current_team_id'),
            'is_active' => Toggle::make('is_active'),
            'is_otp' => Toggle::make('is_otp'),
            'password_expires_at' => DatePicker::make('password_expires_at'),
            'email_verified_at' => DatePicker::make('email_verified_at'),
            'type' => TextInput::make('type'),
            'state' => TextInput::make('state'),
        ];
    }
}
