<?php

declare(strict_types=1);

namespace Modules\User\Filament\Forms\Components;

use Modules\User\Filament\Tables\Columns\SingleRoleSelectColumn;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;

class SingleRoleSelect extends XotBaseSelect
{
    protected string $optionValueProperty = 'id';

    protected function setUp(): void
    {
        parent::setUp();

        /** @var view-string $viewString */
        $viewString = 'user::filament.forms.components.single-role-select';
        $this->view($viewString);

        // Stessa lista della colonna gemella: senza `super-admin` per chi non lo e'.
        $this->options(static fn (): array => SingleRoleSelectColumn::roleOptions())
            ->placeholder('Select a role');
    }

    public function getOptionValueProperty(): string
    {
        return $this->optionValueProperty;
    }
}
