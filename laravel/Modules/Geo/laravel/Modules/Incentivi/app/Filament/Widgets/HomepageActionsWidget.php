<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class HomepageActionsWidget extends XotBaseWidget
{
    protected string $view = 'incentivi::filament.widgets.homepage-actions-widget';

    protected static ?int $sort = 2;

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
