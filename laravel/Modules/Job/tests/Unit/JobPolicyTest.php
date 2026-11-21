<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Modules\Job\Models\Policies\FailedImportRowPolicy;
use Modules\Job\Models\Policies\FailedJobPolicy;
use Modules\Job\Models\Policies\ImportPolicy;
use Modules\Job\Models\Policies\JobBatchPolicy;
use Modules\Job\Models\Policies\JobPolicy;
use Modules\Job\Models\Policies\ScheduleHistoryPolicy;
use Modules\Job\Models\Policies\SchedulePolicy;
use Modules\Job\Models\Policies\TaskCommentPolicy;
use Modules\Job\Models\Policies\TaskPolicy;
use Modules\Job\Models\Schedule;
use Modules\Job\Models\ScheduleHistory;
use Modules\Job\Models\Task;
use Modules\Job\Models\TaskComment;
use Modules\Job\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-job-db');

/**
 * @param  list<string>  $permissions
 * @param  list<string>  $roles
 * @return MockInterface&UserContract
 */
function jobFakeUser(array $permissions = [], bool $ownsTeam = false, bool $belongsToTeam = false, array $roles = []): UserContract
{
    /** @var MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    expectMethod($user, 'hasPermissionTo')
        ->andReturnUsing(static fn (string $permission): bool => in_array($permission, $permissions, true));
    expectMethod($user, 'hasRole')
        ->andReturnUsing(static function (array|string $richiesti) use ($roles): bool {
            /** @var list<string> $normalizzati */
            $normalizzati = is_array($richiesti) ? $richiesti : [$richiesti];

            return array_intersect($normalizzati, $roles) !== [];
        });
    expectMethod($user, 'ownsTeam')->andReturn($ownsTeam);
    expectMethod($user, 'belongsToTeam')->andReturn($belongsToTeam);

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

test('TaskPolicy richiede permessi task.*', function (): void {
    $policy = new TaskPolicy;
    $task = new Task;

    Assert::assertTrue($policy->viewAny(jobFakeUser(['task.viewAny'])));
    Assert::assertTrue($policy->view(jobFakeUser(['task.view']), $task));
    Assert::assertTrue($policy->create(jobFakeUser(['task.create'])));
    Assert::assertTrue($policy->update(jobFakeUser(['task.update']), $task));
    Assert::assertTrue($policy->delete(jobFakeUser(['task.delete']), $task));
});

test('SchedulePolicy e ScheduleHistoryPolicy espongono CRUD', function (): void {
    $schedulePolicy = new SchedulePolicy;
    $schedule = new Schedule;
    Assert::assertTrue($schedulePolicy->viewAny(jobFakeUser(['schedule.viewAny'])));
    Assert::assertTrue($schedulePolicy->view(jobFakeUser(['schedule.view']), $schedule));

    $historyPolicy = new ScheduleHistoryPolicy;
    $history = new ScheduleHistory;
    Assert::assertTrue($historyPolicy->viewAny(jobFakeUser(['schedule_history.viewAny'])));
    Assert::assertTrue($historyPolicy->view(jobFakeUser(['schedule_history.view']), $history));
});

test('TaskCommentPolicy espone CRUD', function (): void {
    $policy = new TaskCommentPolicy;
    $comment = new TaskComment;

    Assert::assertTrue($policy->create(jobFakeUser(['task_comment.create'])));
    Assert::assertTrue($policy->update(jobFakeUser(['task_comment.update']), $comment));
});

test('JobPolicy deny-default su jobs', function (): void {
    $policy = new JobPolicy;
    $job = new \Modules\Job\Models\Job;

    Assert::assertFalse($policy->viewAny(jobFakeUser()));
    Assert::assertFalse($policy->create(jobFakeUser()));
    Assert::assertFalse($policy->view(jobFakeUser(), $job));
    Assert::assertFalse($policy->delete(jobFakeUser(), $job));
    Assert::assertTrue($policy->before(jobFakeUser(roles: ['super-admin']), 'create'));
});

test('FailedJobPolicy e JobBatchPolicy deny-default', function (): void {
    $failed = new \Modules\Job\Models\FailedJob;
    $batch = new \Modules\Job\Models\JobBatch;
    foreach ([
        [new FailedJobPolicy, $failed],
        [new JobBatchPolicy, $batch],
    ] as [$policy, $model]) {
        Assert::assertFalse($policy->viewAny(jobFakeUser()));
        Assert::assertFalse($policy->create(jobFakeUser()));
        Assert::assertFalse($policy->view(jobFakeUser(), $model));
        Assert::assertTrue($policy->before(jobFakeUser(roles: ['job::admin']), 'create'));
    }
});

test('policy stub ereditano JobBasePolicy', function (): void {
    foreach ([new ImportPolicy, new FailedImportRowPolicy] as $policy) {
        Assert::assertTrue($policy->before(jobFakeUser(), 'viewAny') === null);
    }
});
