<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Meetup\Models\Event;

class MeetupStatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('start_date', '>', now())->count();
        $publishedEvents = Event::where('status', 'published')->count();

        return [
            Stat::make(__('meetup::meetup_stats_overview.stats.total.label'), $totalEvents)
                ->description(__('meetup::meetup_stats_overview.stats.total.description'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
            Stat::make(__('meetup::meetup_stats_overview.stats.upcoming.label'), $upcomingEvents)
                ->description(__('meetup::meetup_stats_overview.stats.upcoming.description'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(__('meetup::meetup_stats_overview.stats.published.label'), $publishedEvents)
                ->description(__('meetup::meetup_stats_overview.stats.published.description'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
        ];
    }
}
