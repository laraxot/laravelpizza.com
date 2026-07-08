<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

use function Safe\date;

class CriteriMaggiorazioneForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'anno' => TextInput::make('anno')

                ->required()
                ->numeric()
                ->default(date('Y')),
            'min_valutaz_perf_ind' => TextInput::make('min_valutaz_perf_ind')

                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->step(0.01),
            'maggiorazione_perc' => TextInput::make('maggiorazione_perc')

                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->step(0.01)
                ->suffix('%'),
            'created_by' => TextInput::make('created_by')

                ->maxLength(50)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),
        ];
    }
}
