<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CondizioniLavoroInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'matr' => TextEntry::make('matr'),
            'cognome' => TextEntry::make('cognome'),
            'nome' => TextEntry::make('nome'),
            'stabi' => TextEntry::make('stabi'),
            'repar' => TextEntry::make('repar'),
            'dal' => TextEntry::make('dal'),
            'al' => TextEntry::make('al'),
            'anno' => TextEntry::make('anno'),
            'valutatore_id' => TextEntry::make('valutatore_id'),
            'indennitaTipoDettaglio' => TextEntry::make('indennitaTipoDettaglio'),
            'lavoratore' => TextEntry::make('lavoratore'),
            'quadrimestre' => TextEntry::make('quadrimestre'),
            'anno/valutatore' => TextEntry::make('anno/valutatore'),
        ];
    }
}
