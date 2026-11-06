<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Translation\PotentiallyTranslatedString;
use Mockery;
use Mockery\MockInterface;
use Modules\Job\Models\Policies\ExportPolicy;
use Modules\Job\Models\Policies\FailedImportRowPolicy;
use Modules\Job\Models\Policies\FailedJobPolicy;
use Modules\Job\Models\Policies\ImportPolicy;
use Modules\Job\Models\Policies\JobBatchPolicy;
use Modules\Job\Models\Policies\JobManagerPolicy;
use Modules\Job\Models\Policies\JobPolicy;
use Modules\Job\Models\Policies\JobsWaitingPolicy;
use Modules\Job\Models\Policies\ScheduleHistoryPolicy;
use Modules\Job\Models\Policies\SchedulePolicy;
use Modules\Job\Models\Policies\TaskCommentPolicy;
use Modules\Job\Models\Policies\TaskPolicy;
use Modules\Job\Models\Schedule;
use Modules\Job\Models\ScheduleHistory;
use Modules\Job\Models\Task;
use Modules\Job\Models\TaskComment;
use Modules\Job\Rules\Corn;
use Modules\Job\Tests\TestCase;
use Modules\User\Models\Team;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-job-db');

/**
 * @param  list<string>  $permissions
 * @param  list<string>  $roles
 * @return MockInterface&UserContract
 */
function jobBehaviorUser(array $permissions = [], array $roles = [], bool $ownsTeam = false, bool $belongsToTeam = false): UserContract
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

/**
 * @return \Closure(string, ?string=): PotentiallyTranslatedString
 */
function jobValidationFailure(?string &$message): \Closure
{
    return static function (string $failure, ?string $attribute = null) use (&$message): PotentiallyTranslatedString {
        $message = $failure;

        return new PotentiallyTranslatedString($failure, app(Translator::class));
    };
}

test('JobBasePolicy before concede tutto al super-admin e passa oltre altrimenti', function (): void {
    $policy = new TaskPolicy;
    $super = jobBehaviorUser([], ['super-admin']);
    Assert::assertTrue($policy->before($super, 'viewAny'));

    $normal = jobBehaviorUser(['task.viewAny']);
    Assert::assertNull($policy->before($normal, 'viewAny'));
    Assert::assertTrue($policy->viewAny($normal));
});

test('TaskPolicy rifiuta utente senza permessi e concede con permessi', function (): void {
    $policy = new TaskPolicy;
    $task = new Task;
    $denied = jobBehaviorUser();
    $allowed = jobBehaviorUser([
        'task.viewAny', 'task.view', 'task.create', 'task.update', 'task.delete',
        'task.restore', 'task.forceDelete',
    ]);

    Assert::assertFalse($policy->viewAny($denied));
    Assert::assertFalse($policy->view($denied, $task));
    Assert::assertFalse($policy->create($denied));
    Assert::assertFalse($policy->update($denied, $task));
    Assert::assertFalse($policy->delete($denied, $task));

    Assert::assertTrue($policy->viewAny($allowed));
    Assert::assertTrue($policy->view($allowed, $task));
    Assert::assertTrue($policy->create($allowed));
    Assert::assertTrue($policy->update($allowed, $task));
    Assert::assertTrue($policy->delete($allowed, $task));
});

test('JobPolicy: viewAny e update sempre false; create true; team ops solo owner', function (): void {
    $policy = new JobPolicy;
    $team = new Team;
    $outsider = jobBehaviorUser(ownsTeam: false, belongsToTeam: false);
    $member = jobBehaviorUser(ownsTeam: false, belongsToTeam: true);
    $owner = jobBehaviorUser(ownsTeam: true, belongsToTeam: true);

    Assert::assertFalse($policy->viewAny($outsider));
    Assert::assertFalse($policy->viewAny($owner));
    Assert::assertTrue($policy->create($outsider));
    Assert::assertFalse($policy->update($owner));

    Assert::assertFalse($policy->view($outsider, $team));
    Assert::assertTrue($policy->view($member, $team));

    Assert::assertFalse($policy->addTeamMember($member, $team));
    Assert::assertTrue($policy->addTeamMember($owner, $team));
    Assert::assertTrue($policy->updateTeamMember($owner, $team));
    Assert::assertTrue($policy->removeTeamMember($owner, $team));
    Assert::assertTrue($policy->delete($owner, $team));
    Assert::assertFalse($policy->delete($member, $team));
});

test('Schedule e history policy rispettano permessi specifici', function (): void {
    $schedule = new Schedule;
    $history = new ScheduleHistory;
    $sp = new SchedulePolicy;
    $hp = new ScheduleHistoryPolicy;

    Assert::assertFalse($sp->viewAny(jobBehaviorUser()));
    Assert::assertTrue($sp->viewAny(jobBehaviorUser(['schedule.viewAny'])));
    Assert::assertTrue($sp->view(jobBehaviorUser(['schedule.view']), $schedule));

    Assert::assertFalse($hp->viewAny(jobBehaviorUser()));
    Assert::assertTrue($hp->view(jobBehaviorUser(['schedule_history.view']), $history));
});

test('TaskCommentPolicy deny/allow su permesso task_comment.view', function (): void {
    $policy = new TaskCommentPolicy;
    $comment = new TaskComment;
    Assert::assertFalse($policy->view(jobBehaviorUser(), $comment));
    Assert::assertTrue($policy->view(jobBehaviorUser(['task_comment.view']), $comment));
});

test('FailedJobPolicy e JobBatchPolicy legano view al membership del team', function (): void {
    $team = new Team;
    foreach ([new FailedJobPolicy, new JobBatchPolicy] as $policy) {
        Assert::assertFalse($policy->viewAny(jobBehaviorUser(belongsToTeam: true)));
        Assert::assertTrue($policy->create(jobBehaviorUser()));
        Assert::assertFalse($policy->view(jobBehaviorUser(belongsToTeam: false), $team));
        Assert::assertTrue($policy->view(jobBehaviorUser(belongsToTeam: true), $team));
    }
});

test('Export Import JobsWaiting JobManager FailedImportRow: solo before super-admin (policy vuote)', function (): void {
    foreach ([
        new ExportPolicy,
        new ImportPolicy,
        new JobsWaitingPolicy,
        new JobManagerPolicy,
        new FailedImportRowPolicy,
    ] as $policy) {
        Assert::assertTrue($policy->before(jobBehaviorUser(roles: ['super-admin']), 'viewAny'));
        Assert::assertNull($policy->before(jobBehaviorUser(), 'viewAny'));
    }
});

test('Corn rule: rifiuta non-stringa e cron invalido; accetta espressione valida', function (): void {
    $rule = new Corn;

    $msg = null;
    $rule->validate('expression', 123, jobValidationFailure($msg));
    Assert::assertIsString($msg);
    Assert::assertStringContainsString('not a string', (string) $msg);

    $msg = null;
    $rule->validate('expression', 'not a cron', jobValidationFailure($msg));
    Assert::assertNotNull($msg);

    $msg = null;
    $rule->validate('expression', '0 0 * * *', jobValidationFailure($msg));
    Assert::assertNull($msg);
});
