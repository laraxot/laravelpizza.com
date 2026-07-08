<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\SessionResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class SessionInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, TextEntry>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'user_id' => TextEntry::make('user_id'),
            'ip_address' => TextEntry::make('ip_address'),
            'user_agent' => TextEntry::make('user_agent'),
            'payload' => TextEntry::make('payload'),
            'last_activity' => TextEntry::make('last_activity'),
        ];
    }
}
