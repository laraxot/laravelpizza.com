<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseUserResource\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class BaseUserInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, TextEntry|IconEntry>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'name' => TextEntry::make('name'),
            'first_name' => TextEntry::make('first_name'),
            'last_name' => TextEntry::make('last_name'),
            'email' => TextEntry::make('email'),
            'lang' => TextEntry::make('lang'),
            'current_team_id' => TextEntry::make('current_team_id'),
            'is_active' => IconEntry::make('is_active')->boolean(),
            'is_otp' => IconEntry::make('is_otp')->boolean(),
            'password_expires_at' => TextEntry::make('password_expires_at')->dateTime(),
            'email_verified_at' => TextEntry::make('email_verified_at')->dateTime(),
            'type' => TextEntry::make('type'),
            'state' => TextEntry::make('state'),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
