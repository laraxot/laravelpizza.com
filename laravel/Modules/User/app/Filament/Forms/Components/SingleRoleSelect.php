<?php

declare(strict_types=1);

namespace Modules\User\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Modules\User\Models\Role;

class SingleRoleSelect extends Select
{
    protected string $optionValueProperty = 'id';

    protected function setUp(): void
    {
        parent::setUp();

        /** @var view-string $viewString */
        $viewString = 'user::filament.forms.components.single-role-select';
        $this->view($viewString);

        /** @var array<int|string, string> $options */
        $options = Role::query()->pluck('name', 'id')->toArray();

        $this->options(fn (): array => $options)
            ->placeholder('Select a role');
    }

    public function getOptionValueProperty(): string
    {
        return $this->optionValueProperty;
    }
}
