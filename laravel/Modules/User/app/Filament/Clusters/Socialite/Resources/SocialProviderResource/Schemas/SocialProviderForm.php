<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SocialProviderForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255),
            'scopes' => KeyValue::make('scopes'),
            'client_id' => TextInput::make('client_id')
                ->required()
                ->maxLength(255),
            'client_secret' => TextInput::make('client_secret')
                ->required()
                ->maxLength(1024),
            'redirect' => TextInput::make('redirect')
                ->required()
                ->maxLength(255),
            'parameters' => KeyValue::make('parameters'),
            'additional_params' => Textarea::make('additional_params'),
            'stateless' => Toggle::make('stateless'),
            'active' => Toggle::make('active'),
            'socialite' => Toggle::make('socialite'),
            'enabled' => Toggle::make('enabled'),
            'svg' => Textarea::make('svg')
                ->columnSpanFull(),
        ];
    }
}
