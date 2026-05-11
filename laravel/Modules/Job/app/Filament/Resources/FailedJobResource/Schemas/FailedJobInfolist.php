<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\FailedJobResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * FailedJobInfolist Schema.
 */
class FailedJobInfolist extends XotBaseResourceInfolist
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
            'uuid' => TextEntry::make('uuid'),
            'connection' => TextEntry::make('connection'),
            'queue' => TextEntry::make('queue'),
            'failed_at' => TextEntry::make('failed_at')->dateTime(),
            'exception' => TextEntry::make('exception')->columnSpanFull(),
            'payload' => TextEntry::make('payload')->columnSpanFull(),
        ];
    }
}
