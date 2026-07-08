<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Fields;

use Modules\Xot\Filament\Forms\Components\XotBaseSelect;

class ValutatoreField extends XotBaseSelect
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(function () {
            // TODO: Implementare logica per ottenere opzioni valutatori
            // app(GetValutatoriOptions::class)->execute('Progressioni', $get('anno'))
            return ['a' => 'a']; // Placeholder - da implementare
        });
    }
}
