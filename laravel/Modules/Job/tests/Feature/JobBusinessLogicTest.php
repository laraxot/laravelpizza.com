<?php

declare(strict_types=1);

uses(\Modules\Job\Tests\TestCase::class);

use Modules\Job\Models\Job;

use function Safe\json_encode;

describe('Job Business Logic', function () {
    it('can instantiate job with basic attributes', function () {
        $job = new Job([
            'queue' => 'default',
            'payload' => json_encode(['displayName' => 'App\Jobs\ProcessUserJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        expect($job)
            ->toBeInstanceOf(Job::class)
            ->and($job->queue)->toBe('default')
            ->and($job->attempts)->toBe(0);
    });

    it('returns waiting status when not reserved', function () {
        $job = new Job([
            'queue' => 'high',
            'payload' => json_encode(['displayName' => 'TestJob']),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        expect($job->status)->toBe('waiting');
    });

    it('returns running status when reserved', function () {
        $job = new Job([
            'queue' => 'high',
            'payload' => json_encode(['displayName' => 'TestJob']),
            'attempts' => 1,
            'reserved_at' => now()->timestamp,
            'available_at' => now()->timestamp,
        ]);

        expect($job->status)->toBe('running');
    });

    it('extracts display name from payload', function () {
        $job = new Job([
            'queue' => 'notifications',
            'payload' => json_encode([
                'displayName' => 'App\Jobs\SendNotificationJob',
                'job' => 'Illuminate\Queue\CallQueuedHandler@call',
            ]),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        expect($job->display_name)->toBe('App\Jobs\SendNotificationJob');
    });

    it('handles complex payload structures', function () {
        $complexPayload = [
            'displayName' => 'App\Jobs\ComplexProcessingJob',
            'job' => 'Illuminate\Queue\CallQueuedHandler@call',
            'maxTries' => 5,
            'data' => [
                'user_id' => 789,
                'options' => ['priority' => 'high'],
            ],
        ];

        $job = new Job([
            'queue' => 'processing',
            'payload' => json_encode($complexPayload),
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        expect($job->display_name)->toBe('App\Jobs\ComplexProcessingJob')
            ->and($job->queue)->toBe('processing');
    });

    it('handles job with future available_at', function () {
        $futureTime = now()->addHours(2);

        $job = new Job([
            'queue' => 'scheduled',
            'payload' => json_encode(['displayName' => 'ScheduledJob']),
            'attempts' => 0,
            'available_at' => $futureTime->timestamp,
        ]);

        expect($job->available_at)->toBeGreaterThan(now()->timestamp)
            ->and($job->status)->toBe('waiting');
    });

    it('handles different queue names', function () {
        $highPriorityJob = new Job(['queue' => 'high', 'payload' => '{}', 'attempts' => 0, 'available_at' => now()->timestamp]);
        $lowPriorityJob = new Job(['queue' => 'low', 'payload' => '{}', 'attempts' => 0, 'available_at' => now()->timestamp]);
        $defaultJob = new Job(['queue' => 'default', 'payload' => '{}', 'attempts' => 0, 'available_at' => now()->timestamp]);

        expect($highPriorityJob->queue)->toBe('high')
            ->and($lowPriorityJob->queue)->toBe('low')
            ->and($defaultJob->queue)->toBe('default');
    });

    it('returns null for invalid payload', function () {
        $job = new Job([
            'queue' => 'default',
            'payload' => 'invalid-json',
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ]);

        expect($job->display_name)->toBeNull();
    });

    it('model has correct fillable attributes', function () {
        $job = new Job();
        $fillable = $job->getFillable();

        expect($fillable)->toContain('queue')
            ->and($fillable)->toContain('payload')
            ->and($fillable)->toContain('attempts')
            ->and($fillable)->toContain('available_at');
    });
});
