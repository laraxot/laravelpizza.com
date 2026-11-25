<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

use Modules\Xot\Filament\Widgets\XotBaseWizardWidget;

final class XotAbsWizard3 extends XotBaseWizardWidget
{
    protected string $view = 'xot::filament.widgets.base';

    public function getSteps(): array
    {
        return [];
    }
}
