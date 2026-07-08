<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeTotStabiResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class IndividualeTotStabiInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'stabi' => TextEntry::make('stabi'),
            'tot_budget_assegnato' => TextEntry::make('tot_budget_assegnato'),
            'tot_budget_assegnato_min_punteggio' => TextEntry::make('tot_budget_assegnato_min_punteggio'),
            'tot_quota_effettiva' => TextEntry::make('tot_quota_effettiva'),
            'tot_quota_effettiva_min_punteggio' => TextEntry::make('tot_quota_effettiva_min_punteggio'),
            'tot_resti' => TextEntry::make('tot_resti'),
            'tot_resti_min_punteggio' => TextEntry::make('tot_resti_min_punteggio'),
            'delta' => TextEntry::make('delta'),
            'delta_min_punteggio' => TextEntry::make('delta_min_punteggio'),
            'anno' => TextEntry::make('anno'),
            'created_by' => TextEntry::make('created_by'),
            'updated_by' => TextEntry::make('updated_by'),
            'n_diritto' => TextEntry::make('n_diritto'),
            'n_diritto_excellence' => TextEntry::make('n_diritto_excellence'),
        ];
    }
}
