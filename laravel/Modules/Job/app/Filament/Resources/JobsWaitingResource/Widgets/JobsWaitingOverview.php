<?php

declare(strict_types=1);

/**
 * ---.
 */

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Job\Models\Job;
use Modules\Job\Models\JobManager;
use Modules\Job\Traits\FormatSeconds;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

/**
 * --....
 */
class JobsWaitingOverview extends BaseWidget
{
    use FormatSeconds;

    protected function getCards(): array
    {
        $jobsWaiting = Job::query()->select(DB::raw('COUNT(*) as count'))->first();

        $cast = app(SafeEloquentCastAction::class);
        $waitingJobs = $jobsWaiting instanceof Model
            ? $cast->getIntAttribute($jobsWaiting, 'count', 0)
            : 0;

        $waitingJobsCount = (int) $waitingJobs;

        $aggregationColumns = [
            DB::raw('SUM(finished_at - started_at) as total_time_elapsed'),
            DB::raw('AVG(finished_at - started_at) as average_time_elapsed'),
        ];

        $aggregatedInfo = JobManager::query()->select($aggregationColumns)->first();

        if (! ($aggregatedInfo instanceof Model)) {
            $averageTime = '0';
            $totalTime = '0';
        } else {
            $averageSeconds = (float) $cast->getStringAttribute($aggregatedInfo, 'average_time_elapsed', '0');
            $totalSeconds = (int) $cast->getStringAttribute($aggregatedInfo, 'total_time_elapsed', '0');

            $averageTime = $averageSeconds > 0.0
                ? (string) ceil($averageSeconds).'s'
                : '0';

            $totalTime = $totalSeconds > 0
                ? $this->formatSeconds($totalSeconds).'s'
                : '0';
        }

        return [
            Stat::make('waiting_jobs', $waitingJobsCount),
            Stat::make('execution_time', $totalTime),
            Stat::make('average_time', $averageTime),
        ];
    }
}
