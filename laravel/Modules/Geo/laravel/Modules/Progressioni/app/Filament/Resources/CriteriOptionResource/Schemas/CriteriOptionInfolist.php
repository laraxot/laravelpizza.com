<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriOptionResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CriteriOptionInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id')
                ->dateTime(),
            'name' => TextEntry::make('name')
                ->dateTime(),
            'value' => TextEntry::make('value')
                ->dateTime(),
            'type' => TextEntry::make('type')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'note' => TextEntry::make('note')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
