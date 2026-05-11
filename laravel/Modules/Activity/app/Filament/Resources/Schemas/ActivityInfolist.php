<?php

namespace Modules\Activity\App\Filament\Resources\Schemas;

use Filament\Infolists\Components\Entry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ActivityInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Entry>
     *
     * Campi basati sul Model Activity.php (Spatie ActivityLog):
     * id, log_name, description, subject_type, subject_id, causer_type, causer_id,
     * properties, batch_uuid, event, created_at, updated_at
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'log_name' => TextEntry::make('log_name'),
            'event' => TextEntry::make('event'),
            'description' => TextEntry::make('description')
                ->limit(255),
            'subject_type' => TextEntry::make('subject_type'),
            'subject_id' => TextEntry::make('subject_id'),
            'causer_type' => TextEntry::make('causer_type'),
            'causer_id' => TextEntry::make('causer_id'),
            'batch_uuid' => TextEntry::make('batch_uuid'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
