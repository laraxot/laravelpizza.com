<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class LettIInfolist extends XotBaseResourceInfolist
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
            'dali' => TextEntry::make('dali'),
            'ali' => TextEntry::make('ali'),
            'Indennità' => TextEntry::make('Indennità'),
            'archivista_informatico' => TextEntry::make('archivista_informatico'),
            'relazioni_pubblico' => TextEntry::make('relazioni_pubblico'),
            'protezione_civile' => TextEntry::make('protezione_civile'),
            'formatore_professionale' => TextEntry::make('formatore_professionale'),
            'lavoratore' => TextEntry::make('lavoratore'),
        ];
    }
}
