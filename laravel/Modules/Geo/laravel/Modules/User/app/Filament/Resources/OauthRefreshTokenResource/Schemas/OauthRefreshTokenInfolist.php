<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthRefreshTokenResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OauthRefreshTokenInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model OauthRefreshToken.php -> id, access_token_id, revoked, expires_at
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'access_token_id' => TextEntry::make('access_token_id'),
            'revoked' => TextEntry::make('revoked')
                ->badge(),
            'expires_at' => TextEntry::make('expires_at')
                ->dateTime(),
        ];
    }
}
