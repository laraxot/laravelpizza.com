<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialProviderResource\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\User\Filament\Resources\SocialProviderResource;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SocialProviderForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'env_guide' => Placeholder::make('env_guide')
                ->hiddenLabel()
                ->content(__('fields.env_guide.content'))
                ->columnSpanFull(),
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255),
            'scopes' => KeyValue::make('scopes')
                // ->placeholder(SocialProviderResource::trans('fields.scopes.placeholder'))
                ->helperText(__('fields.scopes.helper_text')),
            'client_id' => TextInput::make('client_id')
                ->maxLength(255)
                ->placeholder(__('fields.client_id.placeholder'))
                ->helperText(__('fields.client_id.helper_text')),
            'client_secret' => TextInput::make('client_secret')
                ->maxLength(1024)
                ->placeholder(__('fields.client_secret.placeholder'))
                ->helperText(__('fields.client_secret.helper_text')),
            'redirect' => TextInput::make('redirect')
                ->required()
                ->maxLength(255)
                ->placeholder(__('fields.redirect.placeholder'))
                ->helperText(__('fields.redirect.helper_text')),
            'parameters' => KeyValue::make('parameters')
                // ->placeholder(SocialProviderResource::trans('fields.parameters.placeholder'))
                ->helperText(__('fields.parameters.helper_text')),
            'additional_params' => Textarea::make('additional_params'),
            'stateless' => Toggle::make('stateless')->helperText(__('fields.stateless.helper_text')),
            'active' => Toggle::make('active')->helperText(__('fields.active.helper_text')),
            'socialite' => Toggle::make('socialite')->helperText(__('fields.socialite.helper_text')),
            'enabled' => Toggle::make('enabled'),
            'svg' => Textarea::make('svg')
                ->columnSpanFull()
                ->placeholder(__('fields.svg.placeholder'))
                ->helperText(__('fields.svg.helper_text')),
        ];
    }
}
