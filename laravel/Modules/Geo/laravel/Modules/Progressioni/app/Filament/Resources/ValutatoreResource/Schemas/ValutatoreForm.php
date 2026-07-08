<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ValutatoreResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ValutatoreForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'id' => TextInput::make('id')->disabled(),
            'stabi' => TextInput::make('stabi'),
            'repar' => TextInput::make('repar'),
            'nome_stabi' => TextInput::make('nome_stabi'),
            'stabi_txt' => TextInput::make('stabi_txt'),
            'repar_txt' => TextInput::make('repar_txt'),
            'ente' => TextInput::make('ente'),
            'matr' => TextInput::make('matr'),
            'anno' => TextInput::make('anno'),
            'nome_diri' => TextInput::make('nome_diri'),
            'nome_diri_plus' => TextInput::make('nome_diri_plus'),
            'budget' => TextInput::make('budget'),
            'valutatore_id' => TextInput::make('valutatore_id'),
        ];
    }
}
