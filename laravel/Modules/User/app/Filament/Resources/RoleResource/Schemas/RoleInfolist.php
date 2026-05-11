<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class RoleInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati sul Model Role.php -> id, uuid, team_id, name, guard_name, display_name, description
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'uuid' => TextEntry::make('uuid'),
            'team_id' => TextEntry::make('team_id'),
            'name' => TextEntry::make('name'),
            'guard_name' => TextEntry::make('guard_name'),
            'display_name' => TextEntry::make('display_name'),
            'description' => TextEntry::make('description'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
