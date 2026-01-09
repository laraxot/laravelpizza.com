<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/**
 * Class ViewOauthClient.
 */
class ViewOauthClient extends XotBaseViewRecord
{
    protected static string $resource = OauthClientResource::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return [
            'oauth_info' => XotBaseSection::make('OAuth Client Information')
                ->schema([
                    'name' => TextEntry::make('name'),
                    'user' => TextEntry::make('user.name'),
                    'redirect' => TextEntry::make('redirect'),
                    'provider' => TextEntry::make('provider'),
                    'personal_access_client' => IconEntry::make('personal_access_client')
                        ->boolean(),
                    'password_client' => IconEntry::make('password_client')
                        ->boolean(),
                    'created_at' => TextEntry::make('created_at')
                        ->dateTime(),
                ]),
        ];
    }
}
