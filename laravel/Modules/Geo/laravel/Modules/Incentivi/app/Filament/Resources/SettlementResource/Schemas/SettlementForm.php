<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\SettlementResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SettlementForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'informazioni_section' => Section::make('Informazioni')
                ->schema([
                    TextInput::make('denominazione')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('importo'),
                ])->columnSpan(1),
        ];
    }
}
