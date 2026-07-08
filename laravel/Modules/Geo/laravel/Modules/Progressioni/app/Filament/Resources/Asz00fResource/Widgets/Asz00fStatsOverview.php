<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\Asz00fResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Progressioni\Actions\GetAsz00fActiveStatsAction;
use Modules\Progressioni\Datas\Asz00fActiveStatsData;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;
use Override;

/**
 * Stats overview sulla lista Asz00f: record attivi e estremi date Sigma.
 *
 * @see https://filamentphp.com/docs/5.x/widgets/stats-overview
 */
class Asz00fStatsOverview extends XotBaseStatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    /**
     * @return array<Stat>
     */
    #[Override]
    protected function getStats(): array
    {
        $stats = app(GetAsz00fActiveStatsAction::class)->execute();

        return [
            $this->makeTotalCountStat($stats),
            $this->makeLowestAsz2kdStat($stats),
            $this->makeHighestAsz2kaStat($stats),
        ];
    }

    private function makeTotalCountStat(Asz00fActiveStatsData $stats): Stat
    {
        return Stat::make(
            __('progressioni::asz00f.widgets.stats.total_count.label'),
            (string) $stats->activeCount,
        )
            ->description(__('progressioni::asz00f.widgets.stats.total_count.description'))
            ->descriptionIcon('heroicon-m-clipboard-document-list')
            ->color('primary');
    }

    private function makeLowestAsz2kdStat(Asz00fActiveStatsData $stats): Stat
    {
        return Stat::make(
            __('progressioni::asz00f.widgets.stats.lowest_asz2kd.label'),
            $this->formatHeadValue($stats->lowestAsz2kd),
        )
            ->description($this->formatTailValues($stats->lowestAsz2kd))
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('info');
    }

    private function makeHighestAsz2kaStat(Asz00fActiveStatsData $stats): Stat
    {
        return Stat::make(
            __('progressioni::asz00f.widgets.stats.highest_asz2ka.label'),
            $this->formatHeadValue($stats->highestAsz2ka),
        )
            ->description($this->formatTailValues($stats->highestAsz2ka))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success');
    }

    /**
     * @param  list<int>  $values
     */
    private function formatHeadValue(array $values): string
    {
        if ($values === []) {
            return '—';
        }

        return (string) $values[0];
    }

    /**
     * @param  list<int>  $values
     */
    private function formatTailValues(array $values): string
    {
        if (count($values) <= 1) {
            return '';
        }

        $tail = array_slice($values, 1);

        return implode(', ', array_map(strval(...), $tail));
    }
}
