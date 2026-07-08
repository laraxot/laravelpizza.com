<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\StabiDirigenteResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Actions\Form\FieldRefreshAction;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class StabiDirigenteForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'id' => TextInput::make('id')
                ->disabled(),
            'valutatore_id' => TextInput::make('valutatore_id'),
            'stabi' => TextInput::make('stabi')->suffixAction(FieldRefreshAction::make('stabi')),
            'repar' => TextInput::make('repar')->suffixAction(FieldRefreshAction::make('repar')),
            'nome_stabi' => TextInput::make('nome_stabi')->suffixAction(FieldRefreshAction::make('nome_stabi')),
            // 'ente' => Forms\Components\TextInput::make('ente'),
            'matr' => TextInput::make('matr'),
            'nome_diri' => TextInput::make('nome_diri'),
            'nome_diri_plus' => TextInput::make('nome_diri_plus'),
            'email' => TextInput::make('email'),
            'anno' => TextInput::make('anno'),
        ];
    }
}
