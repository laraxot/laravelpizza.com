<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamInvitationResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class TeamInvitationInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model TeamInvitation.php -> id, uuid, team_id, email, role, user_id, accepted_at, declined_at
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'uuid' => TextEntry::make('uuid'),
            'team_id' => TextEntry::make('team_id'),
            'email' => TextEntry::make('email'),
            'role' => TextEntry::make('role'),
            'user_id' => TextEntry::make('user_id'),
            'accepted_at' => TextEntry::make('accepted_at')
                ->dateTime(),
            'declined_at' => TextEntry::make('declined_at')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
