<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ClientResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ClientInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model Passport\Client.php -> id, user_id, name, secret, provider, redirect, personal_access_client, password_client, revoked
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'user_id' => TextEntry::make('user_id'),
            'name' => TextEntry::make('name'),
            'provider' => TextEntry::make('provider'),
            'redirect' => TextEntry::make('redirect'),
            'personal_access_client' => TextEntry::make('personal_access_client')
                ->badge(),
            'password_client' => TextEntry::make('password_client')
                ->badge(),
            'revoked' => TextEntry::make('revoked')
                ->badge(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
