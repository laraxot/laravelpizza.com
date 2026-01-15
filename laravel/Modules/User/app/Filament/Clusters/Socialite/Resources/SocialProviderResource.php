<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Modules\User\Filament\Clusters\Socialite;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Pages\CreateSocialProvider;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Pages\EditSocialProvider;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Pages\ListSocialProviders;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Pages\ViewSocialProvider;
use Modules\User\Models\SocialProvider;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * @property SocialProvider $record
 *                                  -------
 */
class SocialProviderResource extends XotBaseResource
{
    protected static ?string $cluster = Socialite::class;

    protected static ?string $model = SocialProvider::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder(__('fields.name.placeholder'))
                ->helperText(__('fields.name.helper_text')),
            'scopes' => KeyValue::make('scopes')
                // ->placeholder(static::trans('fields.scopes.placeholder'))
                ->helperText(__('fields.scopes.helper_text')),
            'client_id' => TextInput::make('client_id')
                ->required()
                ->maxLength(255)
                ->placeholder(__('fields.client_id.placeholder'))
                ->helperText(__('fields.client_id.helper_text')),
            'client_secret' => TextInput::make('client_secret')
                ->required()
                ->maxLength(1024)
                ->placeholder(__('fields.client_secret.placeholder'))
                ->helperText(__('fields.client_secret.helper_text')),
            'redirect' => TextInput::make('redirect')
                ->required()
                ->maxLength(255)
                ->placeholder(__('fields.redirect.placeholder'))
                ->helperText(__('fields.redirect.helper_text')),
            'parameters' => KeyValue::make('parameters')
                // ->placeholder(static::trans('fields.parameters.placeholder'))
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

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSocialProviders::route('/'),
            'create' => CreateSocialProvider::route('/create'),
            'view' => ViewSocialProvider::route('/{record}'),
            'edit' => EditSocialProvider::route('/{record}/edit'),
        ];
    }
}
