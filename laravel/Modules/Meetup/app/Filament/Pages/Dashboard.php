<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;

use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Modules\Meetup\Filament\Widgets\EventCalendarWidget;
use Modules\Meetup\Filament\Widgets\MeetupStatsOverviewWidget;
use Modules\Meetup\Filament\Widgets\RecentEventsWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            MeetupStatsOverviewWidget::class,
            EventCalendarWidget::class,
            RecentEventsWidget::class,
        ];
    }
}
