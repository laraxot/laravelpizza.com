<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class IndividualeDecurtazioneAssenzeForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'anno' => TextInput::make('anno')
                ->numeric(),
            'min_perc' => TextInput::make('min_perc')
                ->numeric(),
            'max_perc' => TextInput::make('max_perc')
                ->numeric(),
            'min_gg_365' => TextInput::make('min_gg_365')
                ->numeric(),
            'max_gg_365' => TextInput::make('max_gg_365')
                ->numeric(),
            'decurtazione_perc' => TextInput::make('decurtazione_perc')
                ->numeric(),

        ];
    }
}
