<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SocialiteUserResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialiteUserResource;
use Modules\User\Filament\Clusters\Socialite\Resources\UserResource;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewSocialiteUser extends XotBaseViewRecord
{
    protected static string $resource = SocialiteUserResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'user_information' => Section::make('User Information')
                ->schema([
                    'user_grid' => Grid::make(2)
                        ->schema([
                            'user_name' => TextEntry::make('user.name')
                                ->url(function (mixed $state, ?SocialiteUser $record): ?string {
                                    if (null === $record) {
                                        return null;
                                    }

                                    $user = $record->user;
                                    if (($user instanceof Model) && $user->exists) {
                                        return UserResource::getUrl('view', ['record' => $user]);
                                    }

                                    return null;
                                }),
                            'provider' => TextEntry::make('provider')
                                ->formatStateUsing(fn ($state): string => is_string($state) ? Str::title($state) : ''),
                        ]),

                    'provider_grid' => Grid::make(2)
                        ->schema([
                            'provider_id' => TextEntry::make('provider_id')
                                ->copyable()
                                ->copyMessage('Provider ID copied'),
                            'name' => TextEntry::make('name'),
                        ]),
                ])->columns(1),

            'contact_information' => Section::make('Contact Information')
                ->schema([
                    'contact_grid' => Grid::make(2)
                        ->schema([
                            'email' => TextEntry::make('email')
                                ->copyable()
                                ->copyMessage('Email copied'),
                            'avatar' => TextEntry::make('avatar')
                                ->url(fn ($state) => $state)
                                ->openUrlInNewTab(),
                        ]),
                ])->columns(1),

            'tokens' => Section::make('Tokens')
                ->schema([
                    'token' => TextEntry::make('token')
                        ->copyable()
                        ->copyMessage('Token copied'),
                ])
                ->collapsible(),

            'timestamps' => Section::make('Timestamps')
                ->schema([
                    'timestamps_grid' => Grid::make(2)
                        ->schema([
                            'created_at' => TextEntry::make('created_at')
                                ->dateTime(),
                            'updated_at' => TextEntry::make('updated_at')
                                ->dateTime(),
                        ]),
                ])->columns(1),
        ];
    }
}
