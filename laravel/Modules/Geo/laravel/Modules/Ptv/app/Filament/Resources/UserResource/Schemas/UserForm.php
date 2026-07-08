<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\UserResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Hash;
use Modules\Ptv\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class UserForm extends XotBaseResourceForm
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
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            'password' => TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(function ($state): ?string {
                    if (! is_string($state) || $state === '') {
                        return null;
                    }

                    return Hash::make($state);
                })
                ->required(fn ($livewire) => $livewire instanceof CreateUser),
        ];
    }
}
