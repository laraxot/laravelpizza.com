<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources\ActivityResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ActivityInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'log_name' => TextEntry::make('log_name'),
            'description' => TextEntry::make('description'),
            'event' => TextEntry::make('event'),
            'subject_type' => TextEntry::make('subject_type'),
            'subject_id' => TextEntry::make('subject_id'),
            'causer_type' => TextEntry::make('causer_type'),
            'causer_id' => TextEntry::make('causer_id'),
            'batch_uuid' => TextEntry::make('batch_uuid')->limit(30),
            'created_at' => TextEntry::make('created_at')->dateTime(),
        ];
    }
}
