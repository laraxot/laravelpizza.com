<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class EsclusiExtraForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'ente' => TextInput::make('ente')->numeric()->required(),
            'matr' => TextInput::make('matr')->numeric()->required(),
            'cognome' => TextInput::make('cognome')->required(),
            'nome' => TextInput::make('nome')->required(),
            'motivo' => Textarea::make('motivo')->rows(3)->required(),
            'anno' => TextInput::make('anno')->numeric()->required(),
        ];
    }
}
