<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseField;

class TreeField extends XotBaseField
{
    /**
     * Setup iniziale del componente.
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var view-string $viewString */
        $viewString = 'ui::filament.forms.components.tree';
        $this->view($viewString);
    }
}
