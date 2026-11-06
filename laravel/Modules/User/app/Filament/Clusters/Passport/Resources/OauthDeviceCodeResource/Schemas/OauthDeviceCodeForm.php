<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthDeviceCodeResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OauthDeviceCodeForm extends XotBaseResourceForm
{
    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'oauth_device_code_info' => Section::make(static::trans('label'))
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
                            'user_code' => TextInput::make('user_code')
                                ->maxLength(8)
                                ->required(),
                        ]),
                    'grid_2' => Grid::make(2)
                        ->schema([
                            'scopes' => TextInput::make('scopes'),
                            'revoked' => TextInput::make('revoked')
                                ->numeric()
                                ->required(),
                            'user_approved_at' => TextInput::make('user_approved_at'),
                            'last_polled_at' => TextInput::make('last_polled_at'),
                            'expires_at' => TextInput::make('expires_at'),
                        ]),
                ]),
        ];
    }
}
