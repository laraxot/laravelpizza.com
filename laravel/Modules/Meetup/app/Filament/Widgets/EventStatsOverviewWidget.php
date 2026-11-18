<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;

/**
 * Riepilogo in cima all'elenco eventi del pannello organizzatore: eventi, eventi in arrivo, iscrizioni attive.
 * Testi in meetup::event_stats_overview (prima erano scritti in italiano nel codice: anche il pannello in inglese
 * mostrava "Totale Eventi").
 */
class EventStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make($this->text('total.label'), Event::query()->count())
                ->description($this->text('total.description'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
            Stat::make($this->text('upcoming.label'), Event::query()->where('start_date', '>=', Carbon::now())->count())
                ->description($this->text('upcoming.description'))
                ->descriptionIcon('heroicon-m-forward')
                ->color('success'),
            // Solo le iscrizioni attive: una iscrizione annullata non è un posto occupato.
            Stat::make($this->text('registrations.label'), (string) EventUser::query()->where('status', 'attending')->count())
                ->description($this->text('registrations.description'))
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }

    private function text(string $key): string
    {
        return (string) __('meetup::event_stats_overview.stats.'.$key);
    }
}
