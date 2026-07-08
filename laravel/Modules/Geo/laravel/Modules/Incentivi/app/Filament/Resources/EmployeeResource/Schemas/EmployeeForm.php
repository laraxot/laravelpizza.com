<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\EmployeeResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Enums\GenderEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class EmployeeForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Form schema types are inferred by Filament v4
        return [
            'matricola' => TextInput::make('matricola')
                ->required()->numeric()->maxLength(5)->unique(),
            'cognome' => TextInput::make('cognome')
                ->required()->string(),
            'nome' => TextInput::make('nome')
                ->required()->string(),
            'sesso' => Select::make('sesso')
                ->options(GenderEnum::class)
                ->required(),
            'codice_fiscale' => TextInput::make('codice_fiscale')
                ->required()->alphaNum()->length(16)
                ->regex('/^(?:[A-Z][AEIOU][AEIOUX]|[AEIOU]X{2}|[B-DF-HJ-NP-TV-Z]{2}[A-Z]){2}(?:[\dLMNP-V]{2}(?:[A-EHLMPR-T](?:[04LQ][1-9MNP-V]|[15MR][\dLMNP-V]|[26NS][0-8LMNP-U])|[DHPS][37PT][0L]|[ACELMRT][37PT][01LM]|[AC-EHLMPR-T][26NS][9V])|(?:[02468LNQSU][048LQU]|[13579MPRTV][26NS])B[26NS][9V])(?:[A-MZ][1-9MNP-V][\dLMNP-V]{2}|[A-M][0L](?:[1-9MNP-V][\dLMNP-V]|[0L][1-9MNP-V]))[A-Z]$/i'),
            'posizione_inail' => TextInput::make('posizione_inail')
                ->required(),
            'tipologia' => TextInput::make('tipologia'),
        ];
    }
}
