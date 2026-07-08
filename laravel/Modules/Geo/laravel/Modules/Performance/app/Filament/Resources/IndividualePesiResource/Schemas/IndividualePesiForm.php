<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePesiResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Ptv\Enums\WorkerType;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class IndividualePesiForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'type' => Select::make('type')
                ->options(WorkerType::class),
            'lista_propro' => TextInput::make('lista_propro')
                ->maxLength(250),
            'descr' => TextInput::make('descr')
                ->maxLength(50),
            'peso_esperienza_acquisita' => TextInput::make('peso_esperienza_acquisita')
                ->numeric(),
            'peso_risultati_ottenuti' => TextInput::make('peso_risultati_ottenuti')
                ->numeric(),
            'peso_arricchimento_professionale' => TextInput::make('peso_arricchimento_professionale')
                ->numeric(),
            'peso_impegno' => TextInput::make('peso_impegno')
                ->numeric(),
            'peso_qualita_prestazione' => TextInput::make('peso_qualita_prestazione')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),

        ];
    }
}
