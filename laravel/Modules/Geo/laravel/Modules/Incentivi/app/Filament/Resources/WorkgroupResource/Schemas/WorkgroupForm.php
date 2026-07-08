<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\WorkgroupResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class WorkgroupForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'informazioni' => Section::make('Informazioni')
                ->schema([
                    TextInput::make('denominazione')
                        ->required()
                        ->maxLength(255),
                ])->columnSpan(1),
        ];
        // )->columns(3);
    }
}
