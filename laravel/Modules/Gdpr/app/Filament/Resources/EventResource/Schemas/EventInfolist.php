<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\EventResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class EventInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'id' => TextEntry::make('id'),
            'treatment_id' => TextEntry::make('treatment_id'),
            'consent_id' => TextEntry::make('consent.id'),
            'subject_id' => TextEntry::make('subject_id'),
            'ip' => TextEntry::make('ip'),
            'action' => TextEntry::make('action'),
            'payload' => TextEntry::make('payload')->columnSpanFull(),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
