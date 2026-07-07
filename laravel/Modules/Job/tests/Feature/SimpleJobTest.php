<?php

declare(strict_types=1);

use Modules\Job\Models\Job;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
uses(TestCase::class);

describe('Job Business Logic', function () {
    it('can create job with basic information', function () {
        $jobData = [
            'queue' => 'default',
            'payload' => [
                'displayName' => 'App\Jobs\ProcessUserJob',
                'job' => 'Illuminate\Queue\CallQueuedHandler@call',
                'maxTries' => 3,
                'maxExceptions' => 0,
                'timeout' => 120,
                'data' => ['user_id' => 123],
            ],
            'attempts' => 0,
            'available_at' => now()->timestamp,
        ];

        $job = Job::create($jobData);

        Assert::assertInstanceOf(Job::class, $job);

        Assert::assertSame('default', $job->queue);

        Assert::assertSame(0, $job->attempts);

        Assert::assertNull($job->reserved_at);
    });
});
