<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget as StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class EventStatsOverviewWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Totale Eventi', Event::count())
                ->description('Eventi registrati nel sistema')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
            Stat::make('Eventi Futuri', Event::where('start_date', '>=', Carbon::now())->count())
                ->description('Eventi in programma')
                ->descriptionIcon('heroicon-m-forward')
                ->color('success'),
            Stat::make('Partecipazioni Totali', \DB::table('event_user')->count())
                ->description('Iscritti totali agli eventi')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
