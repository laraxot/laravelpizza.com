<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Clusters\Socialite;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialiteUserResource\Pages\EditSocialiteUser;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialiteUserResource\Pages\ListSocialiteUsers;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class SocialiteUserResource.
 */
class SocialiteUserResource extends XotBaseResource
{
    protected static ?string $cluster = Socialite::class;

    protected static ?string $model = SocialiteUser::class;

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Select|TextInput>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'user_id' => Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
            'provider' => Select::make('provider')
                ->options([
                    'google' => 'Google',
                    'facebook' => 'Facebook',
                    'github' => 'GitHub',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn',
                    'apple' => 'Apple',
                    // Add other providers as needed
                ])
                ->searchable()
                ->required(),
            'provider_id' => TextInput::make('provider_id')
                ->required()
                ->maxLength(255),
            'provider_token' => TextInput::make('provider_token')
                ->maxLength(255)
                ->password(),
            'provider_refresh_token' => TextInput::make('provider_refresh_token')
                ->maxLength(255)
                ->password(),
            'provider_avatar' => TextInput::make('provider_avatar')
                ->maxLength(255),
        ];
    }

    /**
     * Get the pages available for the resource.
     *
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSocialiteUsers::route('/'),
            'edit' => EditSocialiteUser::route('/{record}/edit'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user']);
    }
}
