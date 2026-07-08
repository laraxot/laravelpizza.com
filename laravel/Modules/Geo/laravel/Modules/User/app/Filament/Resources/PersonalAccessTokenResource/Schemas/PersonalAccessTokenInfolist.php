<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PersonalAccessTokenResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class PersonalAccessTokenInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model PersonalAccessToken.php -> id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'tokenable_type' => TextEntry::make('tokenable_type'),
            'tokenable_id' => TextEntry::make('tokenable_id'),
            'name' => TextEntry::make('name'),
            'abilities' => TextEntry::make('abilities'),
            'last_used_at' => TextEntry::make('last_used_at')
                ->dateTime(),
            'expires_at' => TextEntry::make('expires_at')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
