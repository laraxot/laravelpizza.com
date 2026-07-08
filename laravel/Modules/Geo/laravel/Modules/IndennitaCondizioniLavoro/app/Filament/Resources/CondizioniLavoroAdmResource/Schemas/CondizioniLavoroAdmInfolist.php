<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class CondizioniLavoroAdmInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'lavoratore' => TextEntry::make('lavoratore'),
            'periodo' => TextEntry::make('periodo'),
            'quadrimestre' => TextEntry::make('quadrimestre'),
            'valutatore_id' => TextEntry::make('valutatore_id'),
            'indennitaTipoDettaglio' => TextEntry::make('indennitaTipoDettaglio'),
            'valutatore' => TextEntry::make('valutatore'),
            'cognome' => TextEntry::make('cognome'),
            'nome' => TextEntry::make('nome'),
            'stabi' => TextEntry::make('stabi'),
            'repar' => TextEntry::make('repar'),
            'anno' => TextEntry::make('anno'),
            'anno/valutatore' => TextEntry::make('anno/valutatore'),
        ];
    }
}
