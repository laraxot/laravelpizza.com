<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\AuthenticationLogResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class AuthenticationLogInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model AuthenticationLog.php -> id, authenticatable_type, authenticatable_id, ip_address, user_agent, login_at, login_successful, logout_at, cleared_by_user, location
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'authenticatable_type' => TextEntry::make('authenticatable_type'),
            'authenticatable_id' => TextEntry::make('authenticatable_id'),
            'ip_address' => TextEntry::make('ip_address'),
            'user_agent' => TextEntry::make('user_agent'),
            'login_at' => TextEntry::make('login_at')
                ->dateTime(),
            'login_successful' => TextEntry::make('login_successful')
                ->badge(),
            'logout_at' => TextEntry::make('logout_at')
                ->dateTime(),
            'cleared_by_user' => TextEntry::make('cleared_by_user')
                ->badge(),
            'location' => TextEntry::make('location'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
