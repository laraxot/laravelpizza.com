<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;

use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            // Widgets for the Meetup module can be added here.
        ];
    }
}
