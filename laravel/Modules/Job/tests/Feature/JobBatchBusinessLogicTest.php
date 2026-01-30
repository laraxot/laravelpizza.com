<?php

declare(strict_types=1);

use Modules\Job\Models\Job;
use Modules\Job\Models\JobBatch;
use Modules\Job\Tests\TestCase;

uses(TestCase::class);

it('can create job batch with basic information', function (): void {
    $batchData = [
        'id' => 'batch-123',
        'name' => 'Processamento utenti batch',
        'total_jobs' => 100,
        'pending_jobs' => 100,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([
            'priority' => 'high',
            'notify_on_completion' => true,
        ]),
        'cancelled_at' => null,
        'finished_at' => null,
    ];

    $batch = JobBatch::create($batchData);

    $this->assertDatabaseHas('job_batches', [
        'id' => 'batch-123',
        'name' => 'Processamento utenti batch',
        'total_jobs' => 100,
        'pending_jobs' => 100,
        'failed_jobs' => 0,
    ]);

    expect($batch->id)->toBe('batch-123');
    expect($batch->name)->toBe('Processamento utenti batch');
    expect($batch->total_jobs)->toBe(100);
    expect($batch->pending_jobs)->toBe(100);
    expect($batch->failed_jobs)->toBe(0);
});

it('can manage batch job progression', function (): void {
    $batch = JobBatch::create([
        'id' => 'progression-test',
        'name' => 'Test progressione',
        'total_jobs' => 10,
        'pending_jobs' => 10,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([]),
    ]);

    expect($batch->pending_jobs)->toBe(10);
    expect($batch->failed_jobs)->toBe(0);

    // Simula completamento di alcuni job
    $batch->update([
        'pending_jobs' => 7,
    ]);

    expect($batch->pending_jobs)->toBe(7);
    expect($batch->total_jobs - $batch->pending_jobs)->toBe(3);
});

it('can handle batch job failures', function (): void {
    $batch = JobBatch::create([
        'id' => 'failure-test',
        'name' => 'Test fallimenti',
        'total_jobs' => 5,
        'pending_jobs' => 5,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([]),
    ]);

    // Simula fallimento di alcuni job
    $failedJobIds = ['job-1', 'job-3'];
    $batch->update([
        'failed_jobs' => 2,
        'failed_job_ids' => json_encode($failedJobIds),
        'pending_jobs' => 3,
    ]);

    expect($batch->failed_jobs)->toBe(2);
    expect($batch->pending_jobs)->toBe(3);
    expect(json_decode($batch->failed_job_ids, true))->toBe($failedJobIds);
});

it('can manage batch completion status', function (): void {
    $batch = JobBatch::create([
        'id' => 'completion-test',
        'name' => 'Test completamento',
        'total_jobs' => 3,
        'pending_jobs' => 3,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([]),
    ]);

    expect($batch->finished())->toBeFalse();
    expect($batch->cancelled())->toBeFalse();

    // Simula completamento
    $batch->update([
        'pending_jobs' => 0,
        'finished_at' => now(),
    ]);

    expect($batch->finished())->toBeTrue();
    expect($batch->cancelled())->toBeFalse();
});

it('can handle batch cancellation', function (): void {
    $batch = JobBatch::create([
        'id' => 'cancellation-test',
        'name' => 'Test cancellazione',
        'total_jobs' => 5,
        'pending_jobs' => 5,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([]),
    ]);

    expect($batch->cancelled())->toBeFalse();

    // Cancella il batch
    $batch->update([
        'cancelled_at' => now(),
    ]);

    expect($batch->cancelled())->toBeTrue();
});

it('can manage batch options and configuration', function (): void {
    $options = [
        'priority' => 'high',
        'notify_on_completion' => true,
        'retry_failed_jobs' => true,
        'max_retries' => 3,
        'timeout' => 3600,
        'tags' => ['user_processing', 'batch'],
    ];

    $batch = JobBatch::create([
        'id' => 'options-test',
        'name' => 'Test opzioni',
        'total_jobs' => 10,
        'pending_jobs' => 10,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode($options),
    ]);

    expect(json_decode($batch->options, true))->toBe($options);
    expect(json_decode($batch->options, true)['priority'])->toBe('high');
    expect(json_decode($batch->options, true)['notify_on_completion'])->toBeTrue();
});

it('can calculate batch progress percentage', function (): void {
    $batch = JobBatch::create([
        'id' => 'progress-test',
        'name' => 'Test progresso',
        'total_jobs' => 100,
        'pending_jobs' => 75,
        'failed_jobs' => 5,
        'failed_job_ids' => json_encode(['job-1', 'job-2', 'job-3', 'job-4', 'job-5']),
        'options' => json_encode([]),
    ]);

    // Calcola progresso: (total - pending) / total
    $completedJobs = $batch->total_jobs - $batch->pending_jobs;
    $progressPercentage = ($completedJobs / $batch->total_jobs) * 100;

    expect($completedJobs)->toBe(25);
    expect($progressPercentage)->toBe(25.0);
});

it('can handle batch job relationships', function (): void {
    $batch = JobBatch::create([
        'id' => 'relationships-test',
        'name' => 'Test relazioni',
        'total_jobs' => 3,
        'pending_jobs' => 3,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([]),
    ]);

    // Crea job associati al batch
    $job1 = Job::create([
        'queue' => 'batch',
        'payload' => json_encode([
            'displayName' => 'BatchJob1',
            'batch_id' => $batch->id,
        ]),
        'attempts' => 0,
        'available_at' => now()->timestamp,
    ]);

    $job2 = Job::create([
        'queue' => 'batch',
        'payload' => json_encode([
            'displayName' => 'BatchJob2',
            'batch_id' => $batch->id,
        ]),
        'attempts' => 0,
        'available_at' => now()->timestamp,
    ]);

    // Verifica che i job siano associati al batch
    expect($job1->payload)->toContain($batch->id);
    expect($job2->payload)->toContain($batch->id);
});

it('can manage batch cleanup and maintenance', function (): void {
    $batch = JobBatch::create([
        'id' => 'cleanup-test',
        'name' => 'Test pulizia',
        'total_jobs' => 10,
        'pending_jobs' => 0,
        'failed_jobs' => 2,
        'failed_job_ids' => json_encode(['job-1', 'job-2']),
        'options' => json_encode([]),
        'finished_at' => now()->subDays(7),
    ]);

    expect($batch->finished())->toBeTrue();
    expect($batch->finished_at < now()->subDays(5))->toBeTrue();

    // Verifica che il batch sia candidato per la pulizia
    expect($batch->finished_at < now()->subDays(5))->toBeTrue();
});

it('can handle batch retry logic', function (): void {
    $batch = JobBatch::create([
        'id' => 'retry-test',
        'name' => 'Test retry',
        'total_jobs' => 5,
        'pending_jobs' => 0,
        'failed_jobs' => 3,
        'failed_job_ids' => json_encode(['job-1', 'job-2', 'job-3']),
        'options' => json_encode([
            'retry_failed_jobs' => true,
            'max_retries' => 2,
        ]),
        'finished_at' => now(),
    ]);

    expect($batch->failed_jobs)->toBe(3);
    expect(json_decode($batch->options, true)['retry_failed_jobs'])->toBeTrue();

    // Simula retry dei job falliti
    $batch->update([
        'pending_jobs' => 3,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'finished_at' => null,
    ]);

    expect($batch->failed_jobs)->toBe(0);
    expect($batch->pending_jobs)->toBe(3);
    expect($batch->finished())->toBeFalse();
});

it('can handle batch notification settings', function (): void {
    $batch = JobBatch::create([
        'id' => 'notification-test',
        'name' => 'Test notifiche',
        'total_jobs' => 10,
        'pending_jobs' => 10,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([
            'notify_on_completion' => true,
            'notify_on_failure' => true,
            'notification_email' => 'admin@example.com',
            'notification_slack' => 'https://hooks.slack.com/...',
        ]),
    ]);

    $options = json_decode($batch->options, true);
    expect($options['notify_on_completion'])->toBeTrue();
    expect($options['notify_on_failure'])->toBeTrue();
    expect($options['notification_email'])->toBe('admin@example.com');
    expect($options['notification_slack'])->toBe('https://hooks.slack.com/...');
});

it('can handle batch bulk operations', function (): void {
    // Crea un batch di batch per testare operazioni bulk
    $batchList = [];
    $statuses = ['active', 'completed', 'failed'];

    for ($i = 1; $i <= 3; $i++) {
        $batchList[] = JobBatch::create([
            'id' => "bulk-batch-{$i}",
            'name' => "Batch bulk {$i}",
            'total_jobs' => $i * 10,
            'pending_jobs' => $i * 5,
            'failed_jobs' => $i,
            'failed_job_ids' => json_encode(["failed-job-{$i}"]),
            'options' => json_encode(['priority' => $statuses[$i - 1]]),
            'status' => $statuses[$i - 1],
        ]);
    }

    expect($batchList)->toHaveCount(3);

    foreach ($batchList as $index => $batch) {
        expect($batch->id)->toBe('bulk-batch-'.($index + 1));
        expect($batch->total_jobs)->toBe(($index + 1) * 10);
        expect($batch->status)->toBe($statuses[$index]);
    }
});

it('can validate batch integrity', function (): void {
    // Test con batch valido
    $validBatch = JobBatch::create([
        'id' => 'valid-batch',
        'name' => 'Batch valido',
        'total_jobs' => 10,
        'pending_jobs' => 10,
        'failed_jobs' => 0,
        'failed_job_ids' => json_encode([]),
        'options' => json_encode([]),
    ]);

    expect($validBatch->id)->not->toBeNull();

    // Verifica che i contatori siano coerenti
    expect($validBatch->failed_jobs)->toBeGreaterThanOrEqual(0);
    expect($validBatch->pending_jobs + $validBatch->failed_jobs)->toBeLessThanOrEqual($validBatch->total_jobs);
});
