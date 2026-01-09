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
            Stat::make('Total Events', $totalEvents)
                ->description('All time events')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
            Stat::make('Upcoming Events', $upcomingEvents)
                ->description('Future scheduled events')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Published Events', $publishedEvents)
                ->description('Currently visible')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
        ];
    }
}
