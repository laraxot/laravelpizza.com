<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CriteriMaggiorazioneInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'min_valutaz_perf_ind' => TextEntry::make('min_valutaz_perf_ind')
                ->dateTime(),
            'maggiorazione_perc' => TextEntry::make('maggiorazione_perc')
                ->dateTime(),
            'created_by' => TextEntry::make('created_by'),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
