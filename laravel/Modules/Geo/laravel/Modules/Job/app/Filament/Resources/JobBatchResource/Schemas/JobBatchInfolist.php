<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobBatchResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * JobBatchInfolist Schema.
 */
class JobBatchInfolist extends XotBaseResourceInfolist
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
            'name' => TextEntry::make('name'),
            'total_jobs' => TextEntry::make('total_jobs'),
            'pending_jobs' => TextEntry::make('pending_jobs'),
            'failed_jobs' => TextEntry::make('failed_jobs'),
            'options' => TextEntry::make('options')->columnSpanFull(),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'cancelled_at' => TextEntry::make('cancelled_at')->dateTime(),
            'finished_at' => TextEntry::make('finished_at')->dateTime(),
        ];
    }
}
