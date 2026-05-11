<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class SectionInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'slug' => TextEntry::make('slug'),
            'blocks' => TextEntry::make('blocks')->markdown(),
        ];
    }
}
