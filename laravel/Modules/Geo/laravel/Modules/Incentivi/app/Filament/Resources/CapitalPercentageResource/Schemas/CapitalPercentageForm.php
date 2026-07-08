<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\CapitalPercentageResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Incentivi\Enums\AmbitoIncentivo;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class CapitalPercentageForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'form' => Section::make('')
                ->schema([
                    'nome' => TextInput::make('nome')
                        ->required()
                        ->maxLength(255),
                    'descrizione' => TextInput::make('descrizione')
                        ->required()
                        ->maxLength(255),
                    'tipologia' => Select::make('tipologia')
                        ->options(AmbitoIncentivo::class)
                        ->required(),
                    'da' => TextInput::make('da')
                        ->required()
                        ->numeric(),
                    'a' => TextInput::make('a')
                        ->required()
                        ->numeric(),
                    'valore' => TextInput::make('valore')
                        ->required()
                        ->numeric()
                        ->suffix('%'),
                ])->columns(3),
        ];
    }
}
