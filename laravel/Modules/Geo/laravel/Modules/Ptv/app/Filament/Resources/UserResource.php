<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Support\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\Ptv\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class UserResource extends XotBaseResource
{
    /**
     * @return array<string, Component>
     */
    #[Override]
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

    /**
     * @return class-string<Model>
     */
    #[Override]
    public static function getModel(): string
    {
        $xot = XotData::make();

        return $xot->getUserClass();
    }
}
