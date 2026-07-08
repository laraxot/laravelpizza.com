<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\LogResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Infolists\Components\FileContentEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class LogInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name')
                ->columnSpanFull(),
            'file-content' => FileContentEntry::make('file-content'),
        ];
    }
}
