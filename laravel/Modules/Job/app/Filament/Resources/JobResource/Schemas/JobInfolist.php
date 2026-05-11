<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * JobInfolist Schema.
 */
class JobInfolist extends XotBaseResourceInfolist
{
    /**
     * Get the infolist schema.
     *
     * @return array<int|string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'queue' => TextEntry::make('queue'),
            'payload' => TextEntry::make('payload')->columnSpanFull(),
            'attempts' => TextEntry::make('attempts'),
            'available_at' => TextEntry::make('available_at')->dateTime(),
            'created_at' => TextEntry::make('created_at')->dateTime(),
        ];
    }
}
