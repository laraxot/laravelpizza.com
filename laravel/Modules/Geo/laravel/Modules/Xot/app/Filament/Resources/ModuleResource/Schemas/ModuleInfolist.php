<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ModuleResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ModuleInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, TextEntry>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'description' => TextEntry::make('description'),
            'status' => TextEntry::make('status')->badge(),
            'priority' => TextEntry::make('priority'),
            'path' => TextEntry::make('path'),
            'icon' => TextEntry::make('icon'),
            'colors' => TextEntry::make('colors'),
        ];
    }
}
