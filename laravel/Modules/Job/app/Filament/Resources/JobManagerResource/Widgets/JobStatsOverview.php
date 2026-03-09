<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobManagerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Modules\Job\Models\JobManager;
use Modules\Job\Traits\FormatSeconds;

class JobStatsOverview extends BaseWidget
{
    use FormatSeconds;

    protected function getCards(): array
    {
        $aggregationColumns = [
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(finished_at - started_at) as total_time_elapsed'),
            DB::raw('AVG(finished_at - started_at) as average_time_elapsed'),
        ];

        $aggregatedInfo = JobManager::query()->select($aggregationColumns)->first();

        $totalJobs = (int) ($aggregatedInfo->count ?? 0);
        $totalTime = $this->formatSeconds((int) ($aggregatedInfo->total_time_elapsed ?? 0));
        $averageTime = round((float) ($aggregatedInfo->average_time_elapsed ?? 0), 2).'s';

        return [
            Stat::make('Totale Jobs', (string) $totalJobs),
            Stat::make('Tempo Totale', $totalTime),
            Stat::make('Media Esecuzione', $averageTime),
        ];
    }
}
