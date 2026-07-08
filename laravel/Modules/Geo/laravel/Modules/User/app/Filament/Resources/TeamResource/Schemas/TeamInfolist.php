<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class TeamInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component|Htmlable|string>
     *
     * Campi basati su Model Team.php -> id, uuid, user_id, owner_id, name, personal_team, code, slug, description, avatar_path, settings
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'uuid' => TextEntry::make('uuid'),
            'user_id' => TextEntry::make('user_id'),
            'owner_id' => TextEntry::make('owner_id'),
            'name' => TextEntry::make('name'),
            'slug' => TextEntry::make('slug'),
            'description' => TextEntry::make('description'),
            'personal_team' => TextEntry::make('personal_team')
                ->badge()
                ->formatStateUsing(fn (int $state): string => $state ? 'Yes' : 'No'),
            'code' => TextEntry::make('code'),
            'avatar_path' => TextEntry::make('avatar_path'),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
