<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MessageResource\Schemas;

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
            'type' => TextEntry::make('type')
                ->dateTime(),
            'new_type' => TextEntry::make('new_type'),
            'title' => TextEntry::make('title')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'txt' => TextEntry::make('txt')
                ->dateTime(),
            'id' => TextEntry::make('id')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
