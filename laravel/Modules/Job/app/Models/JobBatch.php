<?php

/**
 * ---.
 *
 * @see https://philo.dev/laravel-batches-and-real-time-progress-with-livewire/
 * @see https://philo.dev/laravel-batches-and-real-time-progress-with-livewire/
 */

declare(strict_types=1);

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Job\Database\Factories\JobBatchFactory;
use Modules\Xot\Contracts\ProfileContract;
use Override;

/**
 * Modules\Job\Models\JobBatch.
 *
 * @property string $id
 * @property string $name
 * @property int $total_jobs
 * @property int $pending_jobs
 * @property int $failed_jobs
 * @property string $failed_job_ids
 * @property Collection<array-key, mixed>|null $options
 * @property Carbon|null $cancelled_at
 * @property Carbon $created_at
 * @property Carbon|null $finished_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 *
 * @method static JobBatchFactory factory($count = null, $state = [])
 * @method static Builder<static>|JobBatch newModelQuery()
 * @method static Builder<static>|JobBatch newQuery()
 * @method static Builder<static>|JobBatch query()
 * @method static Builder<static>|JobBatch whereCancelledAt($value)
 * @method static Builder<static>|JobBatch whereCreatedAt($value)
 * @method static Builder<static>|JobBatch whereFailedJobIds($value)
 * @method static Builder<static>|JobBatch whereFailedJobs($value)
 * @method static Builder<static>|JobBatch whereFinishedAt($value)
 * @method static Builder<static>|JobBatch whereId($value)
 * @method static Builder<static>|JobBatch whereName($value)
 * @method static Builder<static>|JobBatch whereOptions($value)
 * @method static Builder<static>|JobBatch wherePendingJobs($value)
 * @method static Builder<static>|JobBatch whereTotalJobs($value)
 *
 * @property-read ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class JobBatch extends BaseModel
{
    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'total_jobs',
        'pending_jobs',
        'failed_jobs',
        'failed_job_ids',
        'options',
        'cancelled_at',
        'created_at',
        'finished_at',
    ];

    /**
     * Get the total number of jobs that have been processed by the batch thus far.
     *
     * @return int
     */
    public function processedJobs(): int|float
    {
        $totalJobs = (int) ($this->attributes['total_jobs'] ?? 0);
        $pendingJobs = (int) ($this->attributes['pending_jobs'] ?? 0);

        return $totalJobs - $pendingJobs;
    }

    /**
     * Get the percentage of jobs that have been processed (between 0-100).
     */
    public function progress(): int
    {
        $totalJobs = (int) ($this->attributes['total_jobs'] ?? 0);
        $progress = $totalJobs > 0 ? round($this->processedJobs() / $totalJobs * 100) : 0;

        return (int) $progress;
    }

    /**
     * Determine if the batch has pending jobs.
     */
    public function hasPendingJobs(): bool
    {
        $pendingJobs = (int) ($this->attributes['pending_jobs'] ?? 0);

        return $pendingJobs > 0;
    }

    /**
     * Determine if the batch has finished executing.
     */
    public function finished(): bool
    {
        $finishedAt = $this->attributes['finished_at'] ?? null;

        return $finishedAt instanceof Carbon;
    }

    /**
     * Determine if the batch has job failures.
     */
    public function hasFailures(): bool
    {
        $failedJobs = (int) ($this->attributes['failed_jobs'] ?? 0);

        return $failedJobs > 0;
    }

    /**
     * Determine if all jobs failed.
     */
    public function failed(): bool
    {
        $failedJobs = (int) ($this->attributes['failed_jobs'] ?? 0);
        $totalJobs = (int) ($this->attributes['total_jobs'] ?? 0);

        return $failedJobs === $totalJobs;
    }

    /**
     * Determine if the batch has been canceled.
     */
    public function cancelled(): bool
    {
        $cancelledAt = $this->attributes['cancelled_at'] ?? null;

        return $cancelledAt instanceof Carbon;
    }

    /**  @return array<string, string>  */
    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'name' => 'string',
            'total_jobs' => 'integer',
            'pending_jobs' => 'integer',
            'failed_jobs' => 'integer',
            'failed_job_ids' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'options' => 'collection',
            'cancelled_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }
}
