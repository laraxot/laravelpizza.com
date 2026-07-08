<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class IndennitaResponsabilitaForm extends XotBaseResourceForm
{
    /**
     * Campi editabili allineati a CompilaIndennitaResponsabilita (periodo e note).
     *
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'dal' => DatePicker::make('dal'),
            'al' => DatePicker::make('al'),
            'note' => Textarea::make('note')->columnSpanFull(),
        ];
    }
}
