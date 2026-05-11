<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class AttachmentInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<int|string, Component|Htmlable|string>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'title' => TextEntry::make('title'),
            'description' => TextEntry::make('description'),
            'slug' => TextEntry::make('slug'),
            'disk' => TextEntry::make('disk'),
            'attachment' => TextEntry::make('attachment'),
        ];
    }
}
