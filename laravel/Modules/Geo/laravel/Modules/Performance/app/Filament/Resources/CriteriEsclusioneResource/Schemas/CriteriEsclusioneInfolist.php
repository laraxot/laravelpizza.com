<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CriteriEsclusioneInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name')
                ->dateTime(),
            'field_name' => TextEntry::make('field_name')
                ->dateTime(),
            'op' => TextEntry::make('op')
                ->dateTime(),
            'value' => TextEntry::make('value')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'is_enabled' => TextEntry::make('is_enabled')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
