<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\CacheLockResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CacheLockInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, TextEntry>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'key' => TextEntry::make('key'),
            'owner' => TextEntry::make('owner'),
            'expiration' => TextEntry::make('expiration'),
        ];
    }
}
