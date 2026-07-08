<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class UserInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model User.php -> id, name, first_name, last_name, email, email_verified_at, current_team_id, profile_photo_path, lang, is_active, is_otp, password_expires_at, type, state
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'name' => TextEntry::make('name'),
            'first_name' => TextEntry::make('first_name'),
            'last_name' => TextEntry::make('last_name'),
            'email' => TextEntry::make('email'),
            'email_verified_at' => TextEntry::make('email_verified_at')
                ->dateTime(),
            'current_team_id' => TextEntry::make('current_team_id'),
            'profile_photo_path' => TextEntry::make('profile_photo_path'),
            'lang' => TextEntry::make('lang'),
            'is_active' => TextEntry::make('is_active')
                ->badge(),
            'is_otp' => TextEntry::make('is_otp')
                ->badge(),
            'password_expires_at' => TextEntry::make('password_expires_at')
                ->dateTime(),
            'type' => TextEntry::make('type'),
            'state' => TextEntry::make('state'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
