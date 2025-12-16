<?php

/**
 * Class Modules\Job\Providers\JobServiceProvider.
 *
 * @see https://github.com/mooxphp/jobs/blob/main/src/JobManagerProvider.php
 */

declare(strict_types=1);

namespace Modules\Job\Providers;

use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Modules\Job\Events\Executed;
use Modules\Job\Events\Executing;
use Modules\Job\Models\Task;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Override;

class JobServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Job';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[Override]
    public function boot(): void
    {
        parent::boot();
        /*
         * $this->app->resolving(Schedule::class, function ($schedule) {
         * dddx($schedule);
         * //
         * });
         */
        // $this->app->booted(function () {
        // $schedule = $this->app->make(Schedule::class);
        // try {
        //    $this->registerSchedule($schedule);
        // } catch (\Illuminate\Database\QueryException $e) {
        //    echo $e->getMessage();
        // }
        // });
        Import::polymorphicUserRelationship();
        Export::polymorphicUserRelationship();
        $this->registerQueue();
    }

    public function registerQueue(): void
    {
        /*
         * Queue::before(static function (JobProcessing $event) {
         * self::jobStarted($event->job);
         * });
         *
         * Queue::after(static function (JobProcessed $event) {
         * self::jobFinished($event->job);
         * });
         *
         * Queue::failing(static function (JobFailed $event) {
         * self::jobFinished($event->job, true, $event->exception);
         * });
         *
         * Queue::exceptionOccurred(static function (JobExceptionOccurred $event) {
         * self::jobFinished($event->job, true, $event->exception);
         * });
         */
    }

    /*
     * public function registerSchedule(Schedule $schedule): void {
     * if (Schema::hasTable('tasks')) {
     * $tasks = app(Task::class)
     * ->query()
     * ->with('frequencies')
     * ->where('is_active', true)
     * ->get();
     *
     * $tasks->each(
     * function ($task) use ($schedule) {
     * if (! $task instanceof Task) {
     * throw new \Exception('['.__LINE__.']['.class_basename($this).']');
     * }
     * //
     * // var \Illuminate\Console\Scheduling\Event
     * //
     * $event = $schedule->command($task->command, $task->compileParameters(true));
     * // --- funziona solo con daily per ora
     * $event->{$task->expression}()
     * ->name($task->description)
     * ->timezone($task->timezone)
     * ->before(function () use ($task) {
     * //Access to an undefined property Illuminate\Console\Scheduling\Event::$start.
     * //$event->start = microtime(true);
     * Executing::dispatch($task);
     * })
     * ->thenWithOutput(function ($output) use ($event, $task) {
     * Executed::dispatch($task, $event->start ?? microtime(true), $output);
     * });
     * if ($task->dont_overlap) {
     * $event->withoutOverlapping();
     * }
     * if ($task->run_in_maintenance) {
     * $event->evenInMaintenanceMode();
     * }
     * if ($task->run_on_one_server && in_array(config('cache.default'), ['memcached', 'redis', 'database', 'dynamodb'])) {
     * $event->onOneServer();
     * }
     * if ($task->run_in_background) {
     * $event->runInBackground();
     * }
     * });
     * }
     * }
     */
}
