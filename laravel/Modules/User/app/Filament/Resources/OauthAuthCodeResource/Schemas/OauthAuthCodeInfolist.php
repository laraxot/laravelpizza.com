<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthAuthCodeResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OauthAuthCodeInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model OauthAuthCode.php -> id, user_id, client_id, scopes, revoked, expires_at
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'user_id' => TextEntry::make('user_id'),
            'client_id' => TextEntry::make('client_id'),
            'scopes' => TextEntry::make('scopes'),
            'revoked' => TextEntry::make('revoked')
                ->badge(),
            'expires_at' => TextEntry::make('expires_at')
                ->dateTime(),
        ];
    }
}
