<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ProfileResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ProfileInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model Profile.php -> id, uuid, user_id, type, first_name, last_name, email, phone, address, bio, avatar, timezone, locale, status, is_active, preferences
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'uuid' => TextEntry::make('uuid'),
            'user_id' => TextEntry::make('user_id'),
            'type' => TextEntry::make('type'),
            'first_name' => TextEntry::make('first_name'),
            'last_name' => TextEntry::make('last_name'),
            'full_name' => TextEntry::make('full_name'),
            'email' => TextEntry::make('email'),
            'phone' => TextEntry::make('phone'),
            'address' => TextEntry::make('address'),
            'bio' => TextEntry::make('bio'),
            'avatar' => TextEntry::make('avatar'),
            'timezone' => TextEntry::make('timezone'),
            'locale' => TextEntry::make('locale'),
            'status' => TextEntry::make('status'),
            'is_active' => TextEntry::make('is_active')
                ->badge(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
