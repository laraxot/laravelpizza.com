<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaTotStabiResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OrganizzativaTotStabiForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'stabi' => TextInput::make('stabi')
                ->numeric(),
            'tot_budget_assegnato' => TextInput::make('tot_budget_assegnato')
                ->numeric(),
            'tot_budget_assegnato_min_punteggio' => TextInput::make('tot_budget_assegnato_min_punteggio')
                ->numeric(),
            'tot_quota_effettiva' => TextInput::make('tot_quota_effettiva')
                ->numeric(),
            'tot_quota_effettiva_min_punteggio' => TextInput::make('tot_quota_effettiva_min_punteggio')
                ->numeric(),
            'tot_resti' => TextInput::make('tot_resti')
                ->numeric(),
            'tot_resti_min_punteggio' => TextInput::make('tot_resti_min_punteggio')
                ->numeric(),
            'delta' => TextInput::make('delta')
                ->numeric(),
            'delta_min_punteggio' => TextInput::make('delta_min_punteggio')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),

        ];
    }
}
