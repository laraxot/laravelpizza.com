<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class PageInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'title' => TextEntry::make('title'),
            'slug' => TextEntry::make('slug'),
            'description' => TextEntry::make('description')->limit(100),
            'content' => TextEntry::make('content')->limit(200)->html(),
            'middleware' => TextEntry::make('middleware'),
        ];
    }
}
