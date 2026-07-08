<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OrganizzativaCatCoeffForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'lista_propro' => TextInput::make('lista_propro')
                ->maxLength(250),
            'coeff' => TextInput::make('coeff')
                ->numeric(),
            'descr' => Textarea::make('descr')
                ->columnSpanFull(),
            'tot_giorni' => TextInput::make('tot_giorni')
                ->numeric(),
            'tot_giorni_pt' => TextInput::make('tot_giorni_pt')
                ->numeric(),
            'tot_giorni_pt_coeff' => TextInput::make('tot_giorni_pt_coeff')
                ->numeric(),
            'quota_teorica' => TextInput::make('quota_teorica')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),

        ];
    }
}
