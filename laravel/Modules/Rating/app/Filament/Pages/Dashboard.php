<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Pages;

use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Modules\Rating\Filament\Widgets\RatingPanelStatsOverviewWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

/**
 * Dashboard del pannello Rating con conteggi criteri/morph.
 *
 * @see Modules/Rating/docs/rating-panel-dashboard.md
 */
class Dashboard extends XotBaseDashboard
{
    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     *
     * @see Modules/Rating/docs/rating-panel-dashboard.md
     */
    public function getWidgets(): array
    {
        return [
            RatingPanelStatsOverviewWidget::class,
        ];
    }
}
