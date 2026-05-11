<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class JobsWaitingInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'queue' => TextEntry::make('queue'),
            'payload' => TextEntry::make('payload'),
            'attempts' => TextEntry::make('attempts'),
            'reserved_at' => TextEntry::make('reserved_at')
                ->dateTime(),
            'available_at' => TextEntry::make('available_at')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
        ];
    }
}
