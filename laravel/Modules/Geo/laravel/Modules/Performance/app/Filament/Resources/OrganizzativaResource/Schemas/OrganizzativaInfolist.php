<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Ptv\Filament\Infolists\AszEffSection;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

/**
 * Infolist dedicato per la risorsa Organizzativa.
 *
 * @see XotBaseResourceInfolist
 */
class OrganizzativaInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'dati_lavoratore' => Section::make('dati_lavoratore')
                ->schema([
                    TextEntry::make('matr'),
                    TextEntry::make('cognome'),
                    TextEntry::make('nome'),
                    TextEntry::make('email'),
                ])
                ->columns(4),

            'dati_struttura' => Section::make('dati_struttura')
                ->schema([
                    TextEntry::make('stabi'),
                    TextEntry::make('stabi_txt'),
                    TextEntry::make('repar'),
                    TextEntry::make('repar_txt'),
                ])
                ->columns(4),

            'periodo_valutazione' => Section::make('periodo_valutazione')
                ->schema([
                    TextEntry::make('dal'),
                    TextEntry::make('al'),
                    TextEntry::make('anno'),
                ])
                ->columns(3),

            'dati_calcolati' => Section::make('dati_calcolati')
                ->schema([
                    TextEntry::make('gg_presenza_dalal'),
                    TextEntry::make('gg_assenza_dalal'),
                    TextEntry::make('hh_assenza_dalal'),
                    TextEntry::make('perc_parttimepond_dalal'),
                ])
                ->columns(4),

            'dati_economici' => Section::make('dati_economici')
                ->schema([
                    TextEntry::make('quota_teorica'),
                    TextEntry::make('budget_assegnato'),
                    TextEntry::make('quota_effettiva'),
                    TextEntry::make('resti'),
                    TextEntry::make('resti_pond'),
                    TextEntry::make('importo_totale'),
                ])
                ->columns(3),
            'asz' => AszEffSection::make('asz')->columnSpanFull(),
        ];
    }
}
