<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MessageResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MessageInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'parent_id' => TextEntry::make('parent_id'),
            'type' => TextEntry::make('type'),
            'new_type' => TextEntry::make('new_type'),
            'title' => TextEntry::make('title'),
            'anno' => TextEntry::make('anno'),
            'txt' => TextEntry::make('txt'),
            'id' => TextEntry::make('id'),
        ];
    }
}
