<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\PesiResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class PesiForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'lista_propro' => TextInput::make('lista_propro')->required(),
            'descr' => TextInput::make('descr')->required(),
            'peso_esperienza_acquisita' => TextInput::make('peso_esperienza_acquisita')->numeric()->required(),
            'peso_risultati_ottenuti' => TextInput::make('peso_risultati_ottenuti')->numeric()->required(),
            'peso_arricchimento_professionale' => TextInput::make('peso_arricchimento_professionale')->numeric()->required(),
            'peso_impegno' => TextInput::make('peso_impegno')->numeric()->required(),
            'peso_qualita_prestazione' => TextInput::make('peso_qualita_prestazione')->numeric()->required(),
            'anno' => TextInput::make('anno')->numeric()->required(),
        ];
    }
}
