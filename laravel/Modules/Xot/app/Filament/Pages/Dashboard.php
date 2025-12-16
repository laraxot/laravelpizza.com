<?php

/**
 * @see https://medium.com/@laravelprotips/filament-streamline-multiple-widgets-with-one-dynamic-livewire-filter-ed05c978a97f
 */

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;

class Dashboard extends XotBaseDashboard
{
    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [];
    }
}
