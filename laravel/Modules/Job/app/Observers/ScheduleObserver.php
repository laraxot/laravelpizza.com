<?php

declare(strict_types=1);

/**
 * @see HusamTariq\FilamentDatabaseSchedule
 */

namespace Modules\Job\Observers;

use Modules\Job\Enums\Status;
use Modules\Job\Models\Schedule;
use Modules\Job\Services\ScheduleService;

class ScheduleObserver
{
    /**
     * Undocumented function.
     */
    public function created(): void
    {
        // @var mixed clearCache(;
    }

    /**
     * Undocumented function.
     */
    public function updated(Schedule $_schedule): void
    {
        // @var mixed clearCache(;
    }

    /**
     * Undocumented function.
     */
    public function deleted(Schedule $schedule): void
    {
        $schedule->status = Status::Trashed;
        $schedule->saveQuietly();
        // @var mixed clearCache(;
    }

    /**
     * Undocumented function.
     */
    public function restored(Schedule $schedule): void
    {
        $schedule->status = Status::Inactive;
        $schedule->saveQuietly();
    }

    /**
     * Undocumented function.
     */
    public function saved(Schedule $_schedule): void
    {
        // @var mixed clearCache(;
    }

    /**
     * Undocumented function.
     */
    protected function clearCache(): void
    {
        if (config('job::cache.enabled')) {
            $scheduleService = app(ScheduleService::class);
            if ($scheduleService !== null) {
                $scheduleService->clearCache();
            }
        }
    }
}
