<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\IndennitaTipoResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IndennitaTipoInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'nome' => TextEntry::make('nome')
                ->dateTime(),
            'svocfi' => TextEntry::make('svocfi'),
            'id' => TextEntry::make('id')
                ->dateTime(),
            'descrizione' => TextEntry::make('descrizione')
                ->dateTime(),
            'attivo' => TextEntry::make('attivo')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
