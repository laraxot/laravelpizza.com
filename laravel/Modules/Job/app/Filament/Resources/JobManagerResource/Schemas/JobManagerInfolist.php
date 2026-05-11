<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobManagerResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class JobManagerInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'job_id' => TextEntry::make('job_id'),
            'name' => TextEntry::make('name'),
            'queue' => TextEntry::make('queue'),
            'started_at' => TextEntry::make('started_at')
                ->dateTime(),
            'finished_at' => TextEntry::make('finished_at')
                ->dateTime(),
            'failed' => TextEntry::make('failed'),
            'attempt' => TextEntry::make('attempt'),
            'progress' => TextEntry::make('progress'),
            'exception_message' => TextEntry::make('exception_message'),
        ];
    }
}
