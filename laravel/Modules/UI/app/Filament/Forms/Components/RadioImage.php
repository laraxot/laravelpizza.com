<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseRadio;

final class RadioImage extends XotBaseRadio
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var view-string $viewString */
        $viewString = 'ui::filament.forms.components.radio-image';
        $this->view($viewString);
    }
}
