<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class PerformanceFondoForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'quota_individuale' => TextInput::make('quota_individuale')
                ->numeric(),
            'quota_organizzativa' => TextInput::make('quota_organizzativa')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),
            'note' => Textarea::make('note')
                ->columnSpanFull(),

        ];
    }
}
