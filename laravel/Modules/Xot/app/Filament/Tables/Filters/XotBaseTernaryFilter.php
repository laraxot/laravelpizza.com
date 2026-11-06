<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Filters;

use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\StateCasts\BooleanStateCast;
use Filament\Tables\Filters\TernaryFilter as FilamentTernaryFilter;

/**
 * Ternary
 */
abstract class XotBaseTernaryFilter extends FilamentTernaryFilter
{
    protected function setUp(): void
    {
        parent::setUp();
        /*
        $this->schema(function (): array {
            return [
                ToggleButtons::make('value')
                    ->hiddenLabel()
                    ->grouped()
                    ->options([
                        1 => $this->getTrueLabel() ?? __('filament-forms::components.select.boolean.true'),
                        0 => $this->getFalseLabel() ?? __('filament-forms::components.select.boolean.false'),
                    ])
                    ->colors([
                        1 => 'success',
                        0 => 'danger',
                    ])
                    ->stateCast(app(BooleanStateCast::class, ['isStoredAsInt' => true])),
            ];
        });
        */
    }
}
