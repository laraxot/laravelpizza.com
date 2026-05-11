<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\MenuResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class MenuInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'title' => TextEntry::make('title'),
            'parent_id' => TextEntry::make('parent_id'),
        ];
    }
}
