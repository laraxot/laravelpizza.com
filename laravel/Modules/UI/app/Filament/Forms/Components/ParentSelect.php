<?php

declare(strict_types=1);

/**
 * @see RyanChandler\FilamentNavigation\Filament\Fields\NavigationSelect;
 * @see https://github.com/ryangjchandler/filament-navigation
 */

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Select;

// use RyanChandler\FilamentNavigation\Models\Navigation;

final class ParentSelect extends Select
{
    protected string $optionValueProperty = 'id';

    protected function setUp(): void
    {
        parent::setUp();

        // dddx($this->getModel());
        $this->options(static fn (ParentSelect $_component): array => ['a' => 'a', 'b' => 'b']);
    }

    public function getOptionValueProperty(): string
    {
        return $this->optionValueProperty;
    }
}
