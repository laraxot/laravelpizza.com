<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\DefaultActivityResource\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class DefaultActivityForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Multiple @var tags removed - types inferred by Filament v4
        return [
            'nome' => TextInput::make('nome')
                ->string()
                ->required()
                ->maxLength(255),
            'tipo' => Select::make('tipo')
                ->required()
                ->options([
                    'Lavori' => 'Lavori',
                    'Servizi' => 'Servizi',
                    'Misti' => 'Misti',
                ]),
            'appartiene_a_liquidazione_a_fasi' => Radio::make('appartiene_a_liquidazione_a_fasi')
                ->boolean()
                ->required()
                ->inline()
                ->inlineLabel(false)
                ->live(),
            'liquidazione_fasi' => Select::make('liquidazione_fasi')
                ->options([
                    'Prima' => 'Prima fase',
                    'Seconda' => 'Seconda fase',
                    'Entrambe' => 'Entrambe',
                ])
                ->hidden(fn (Get $get): bool => ! $get('appartiene_a_liquidazione_a_fasi')),
            'quota_percentuale' => TextInput::make('quota_percentuale')
                ->required()
                ->suffix('%'),
            'importo' => TextInput::make('importo')
                ->required()
                ->suffix('€')
                ->disabled()
                ->placeholder('DA ASSEGNARE'),
            'anno_competenza' => TextInput::make('anno_competenza')
                ->required()
                ->maxLength(4),
        ];
    }
}
