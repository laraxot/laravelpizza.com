<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;

class EventsStats extends XotBaseStatsOverviewWidget
{
    /**
     * Get the stats for the widget.
     *
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total Events', (string) Event::count())
                ->description('All recorded meetups')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            Stat::make('Upcoming Events', (string) Event::where('start_date', '>=', now())->count())
                ->description('Planned for the future')
                ->descriptionIcon('heroicon-m-clock')
                ->color('success'),
            Stat::make('Total Attendees', (string) Event::sum('attendees_count'))
                ->description('Members reached')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
