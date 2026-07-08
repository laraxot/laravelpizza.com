<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\PhaseResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class PhaseInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'Informazioni' => TextEntry::make('Informazioni'),
            'name' => TextEntry::make('name'),
            'description' => TextEntry::make('description'),
            'start_date' => TextEntry::make('start_date')
                ->dateTime(),
            'end_date' => TextEntry::make('end_date')
                ->dateTime(),
            'Liquidazione' => TextEntry::make('Liquidazione'),
            'denominazione' => TextEntry::make('denominazione'),
            'importo' => TextEntry::make('importo'),
            'settlement.denominazione' => TextEntry::make('settlement.denominazione'),
        ];
    }
}
