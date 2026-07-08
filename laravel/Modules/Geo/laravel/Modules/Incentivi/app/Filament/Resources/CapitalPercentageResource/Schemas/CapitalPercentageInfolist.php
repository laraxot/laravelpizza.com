<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CapitalPercentageInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'nome' => TextEntry::make('nome')
                ->dateTime(),
            'descrizione' => TextEntry::make('descrizione')
                ->dateTime(),
            'tipologia' => TextEntry::make('tipologia')
                ->dateTime(),
            'da' => TextEntry::make('da')
                ->dateTime(),
            'a' => TextEntry::make('a')
                ->dateTime(),
            'valore' => TextEntry::make('valore')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
