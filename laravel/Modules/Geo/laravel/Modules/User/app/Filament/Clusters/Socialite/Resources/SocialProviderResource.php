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
