<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class LettFInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'Anagrafica' => TextEntry::make('Anagrafica'),
            'ente' => TextEntry::make('ente'),
            'matr' => TextEntry::make('matr'),
            'anno' => TextEntry::make('anno'),
            'cognome' => TextEntry::make('cognome'),
            'nome' => TextEntry::make('nome'),
            'email' => TextEntry::make('email'),
            'stabi' => TextEntry::make('stabi'),
            'repar' => TextEntry::make('repar'),
            'Periodo' => TextEntry::make('Periodo'),
            'dal' => TextEntry::make('dal'),
            'al' => TextEntry::make('al'),
            'dalf' => TextEntry::make('dalf'),
            'alf' => TextEntry::make('alf'),
            'Valutazione' => TextEntry::make('Valutazione'),
            'posizione_lavoro' => TextEntry::make('posizione_lavoro'),
            'complessita' => TextEntry::make('complessita'),
            'coordinamento' => TextEntry::make('coordinamento'),
            'responsabilita' => TextEntry::make('responsabilita'),
            'Importi' => TextEntry::make('Importi'),
            'tot' => TextEntry::make('tot'),
            'valore_economico_calcolato' => TextEntry::make('valore_economico_calcolato'),
            'valore_economico_attribuito' => TextEntry::make('valore_economico_attribuito'),
            'Classificazione' => TextEntry::make('Classificazione'),
            'propro' => TextEntry::make('propro'),
            'posfun' => TextEntry::make('posfun'),
            'categoria_eco' => TextEntry::make('categoria_eco'),
            'lavoratore' => TextEntry::make('lavoratore'),
        ];
    }
}
