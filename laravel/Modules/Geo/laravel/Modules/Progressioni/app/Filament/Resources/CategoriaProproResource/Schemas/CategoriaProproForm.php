<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CategoriaProproResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CategoriaProproForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'categoria' => TextInput::make('categoria')
                ->maxLength(255),
            'lista_propro' => TextInput::make('lista_propro')
                ->maxLength(255),
            'lista_propro_sup' => TextInput::make('lista_propro_sup')
                ->maxLength(255),
            'posti' => TextInput::make('posti')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),
        ];
    }
}
