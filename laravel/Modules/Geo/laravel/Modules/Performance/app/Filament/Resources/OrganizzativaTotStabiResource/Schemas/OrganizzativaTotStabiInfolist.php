<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaTotStabiResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class OrganizzativaTotStabiInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public static function getInfolistSchema(): array
    {
        return [
            'stabi' => TextEntry::make('stabi')
                ->dateTime(),
            'tot_budget_assegnato' => TextEntry::make('tot_budget_assegnato')
                ->dateTime(),
            'tot_budget_assegnato_min_punteggio' => TextEntry::make('tot_budget_assegnato_min_punteggio')
                ->dateTime(),
            'tot_quota_effettiva' => TextEntry::make('tot_quota_effettiva')
                ->dateTime(),
            'tot_quota_effettiva_min_punteggio' => TextEntry::make('tot_quota_effettiva_min_punteggio')
                ->dateTime(),
            'tot_resti' => TextEntry::make('tot_resti')
                ->dateTime(),
            'tot_resti_min_punteggio' => TextEntry::make('tot_resti_min_punteggio')
                ->dateTime(),
            'delta' => TextEntry::make('delta')
                ->dateTime(),
            'delta_min_punteggio' => TextEntry::make('delta_min_punteggio')
                ->dateTime(),
            'anno' => TextEntry::make('anno')
                ->dateTime(),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
            'updated_at' => TextEntry::make('updated_at')
                ->dateTime(),
            'id' => TextEntry::make('id'),
        ];
    }
}
