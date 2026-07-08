<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\StoredEventResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * StoredEventInfolist Schema.
 */
class StoredEventInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<int|string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'event_class' => TextEntry::make('event_class'),
            'aggregate_uuid' => TextEntry::make('aggregate_uuid'),
            'aggregate_version' => TextEntry::make('aggregate_version'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
        ];
    }
}
