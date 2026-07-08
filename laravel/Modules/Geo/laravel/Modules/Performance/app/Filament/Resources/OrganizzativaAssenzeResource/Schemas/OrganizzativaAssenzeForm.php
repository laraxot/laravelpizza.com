<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class OrganizzativaAssenzeForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'tipo' => TextInput::make('tipo')
                ->numeric(),
            'codice' => TextInput::make('codice')
                ->numeric(),
            'descr' => Textarea::make('descr')
                ->columnSpanFull(),
            'anno' => TextInput::make('anno')
                ->numeric(),

        ];
    }
}
