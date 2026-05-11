<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamUserResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class TeamUserInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model TeamUser.php -> id, uuid, team_id, user_id, role, customer_id, permissions, joined_at
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'uuid' => TextEntry::make('uuid'),
            'team_id' => TextEntry::make('team_id'),
            'user_id' => TextEntry::make('user_id'),
            'role' => TextEntry::make('role'),
            'customer_id' => TextEntry::make('customer_id'),
            'permissions' => TextEntry::make('permissions')
                ->badge(),
            'joined_at' => TextEntry::make('joined_at')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
