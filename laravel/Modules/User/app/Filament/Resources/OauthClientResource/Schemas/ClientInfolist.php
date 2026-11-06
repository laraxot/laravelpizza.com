<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ClientInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public function getInfolistSchema(): array
    {
        return [
            'oauth_info' => Section::make('OAuth Client Information')
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
