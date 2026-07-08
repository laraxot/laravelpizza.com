<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ProjectInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'Informazioni' => TextEntry::make('Informazioni'),
            'nome' => TextEntry::make('nome')
                ->dateTime(),
            'tipo' => TextEntry::make('tipo')
                ->dateTime(),
            'stato' => TextEntry::make('stato')
                ->dateTime(),
            'department_id' => TextEntry::make('department_id'),
            'data_aggiudicazione' => TextEntry::make('data_aggiudicazione')
                ->dateTime(),
            'data_inizio_esecuzione' => TextEntry::make('data_inizio_esecuzione')
                ->dateTime(),
            'data_fine_esecuzione' => TextEntry::make('data_fine_esecuzione')
                ->dateTime(),
            'ente_finanziatore' => TextEntry::make('ente_finanziatore'),
            'determina' => TextEntry::make('determina'),
            'oggetto' => TextEntry::make('oggetto')
                ->dateTime(),
            'rup' => TextEntry::make('rup'),
            'dec' => TextEntry::make('dec'),
            'Ditta' => TextEntry::make('Ditta'),
            'ditta_nome' => TextEntry::make('ditta_nome'),
            'ditta_sede' => TextEntry::make('ditta_sede'),
            'ditta_partitaiva' => TextEntry::make('ditta_partitaiva'),
            'ditta_oneri_sicurezza' => TextEntry::make('ditta_oneri_sicurezza'),
            'ditta_trattativa' => TextEntry::make('ditta_trattativa'),
            'Importi e percentuali' => TextEntry::make('Importi e percentuali'),
            'importo_totale' => TextEntry::make('importo_totale')
                ->dateTime(),
            'percentuale_fondo' => TextEntry::make('percentuale_fondo')
                ->dateTime(),
            'importo_effettivo_fondo' => TextEntry::make('importo_effettivo_fondo')
                ->dateTime(),
            'componente_incentivante' => TextEntry::make('componente_incentivante')
                ->dateTime(),
            'componente_innovazione' => TextEntry::make('componente_innovazione')
                ->dateTime(),
            'stabiDirigente.nome_stabi' => TextEntry::make('stabiDirigente.nome_stabi')
                ->dateTime(),
            'determina di aggiudicazione' => TextEntry::make('determina di aggiudicazione')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
        ];
    }
}
