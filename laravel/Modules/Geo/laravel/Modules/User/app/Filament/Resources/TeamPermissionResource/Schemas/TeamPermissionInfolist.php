<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamPermissionResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class TeamPermissionInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model TeamPermission.php -> id, team_id, user_id, permission, name
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'team_id' => TextEntry::make('team_id'),
            'user_id' => TextEntry::make('user_id'),
            'permission' => TextEntry::make('permission'),
            'name' => TextEntry::make('name'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
