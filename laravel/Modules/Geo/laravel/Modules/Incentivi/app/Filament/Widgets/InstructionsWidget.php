<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class InstructionsWidget extends XotBaseWidget
{
    protected string $view = 'incentivi::filament.widgets.instructions-widget';

    protected static ?int $sort = 1;

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
