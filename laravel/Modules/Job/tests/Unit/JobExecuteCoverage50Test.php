<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Illuminate\Console\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Testing\PendingCommand;
use Illuminate\Translation\PotentiallyTranslatedString;
use Mockery;
use Mockery\Expectation;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Modules\Job\Actions\Command\GetCommandsAction;
use Modules\Job\Actions\DummyAction;
use Modules\Job\Enums\Status;
use Modules\Job\Events\BroadcastingEvent;
use Modules\Job\Events\PrivateEvent;
use Modules\Job\Events\PublicEvent;
use Modules\Job\Filament\Columns\ActionGroup;
use Modules\Job\Filament\Resources\ExportResource;
use Modules\Job\Filament\Resources\FailedImportRowResource;
use Modules\Job\Filament\Resources\FailedJobResource;
use Modules\Job\Filament\Resources\ImportResource;
use Modules\Job\Filament\Resources\JobBatchResource;
use Modules\Job\Filament\Resources\JobManagerResource;
use Modules\Job\Filament\Resources\JobResource;
use Modules\Job\Filament\Resources\JobsWaitingResource;
use Modules\Job\Http\Requests\ScheduleRequest;
use Modules\Job\Models\FailedJob;
use Modules\Job\Models\Job;
use Modules\Job\Models\JobBatch;
use Modules\Job\Models\Policies\FailedJobPolicy;
use Modules\Job\Models\Policies\JobBatchPolicy;
use Modules\Job\Models\Policies\JobPolicy;
use Modules\Job\Models\Policies\ResultPolicy;
use Modules\Job\Models\Policies\ScheduleHistoryPolicy;
use Modules\Job\Models\Policies\SchedulePolicy;
use Modules\Job\Models\Policies\TaskCommentPolicy;
use Modules\Job\Models\Policies\TaskPolicy;
use Modules\Job\Models\Result;
use Modules\Job\Models\Schedule;
use Modules\Job\Models\ScheduleHistory;
use Modules\Job\Models\Task;
use Modules\Job\Models\TaskComment;
use Modules\Job\Notifications\TaskCompleted;
use Modules\Job\Observers\ScheduleObserver;
use Modules\Job\Rules\Corn;
use Modules\Job\Tests\TestCase;
use Modules\Job\Traits\FormatSeconds;
use Modules\User\Models\Team;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

/**
 * Real Expectation for one method (shouldReceive() returns a CompositeExpectation, see XotBaseTestCase).
 */
function expectMethod(LegacyMockInterface|MockInterface $mock, string $method): Expectation
{
    return XotBaseTestCase::singleExpectation($mock, $method);
}

use function Safe\ob_get_clean;
use function Safe\ob_start;

uses(TestCase::class)->group('no-job-db');

afterEach(function (): void {
    Mockery::close();
});

function jobBindArtisan(): void
{
    $kernel = app(Kernel::class);
    $method = new \ReflectionMethod($kernel, 'getArtisan');
    $method->setAccessible(true);
    app()->instance(Application::class, $method->invoke($kernel));
}

/**
 * @return MockInterface&UserContract
 */
function jobUser(bool $superAdmin = false): UserContract
{
    /** @var MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldIgnoreMissing();
    expectMethod($user, 'hasRole')->with('super-admin')->andReturn($superAdmin);
    expectMethod($user, 'can')->andReturn(true);
    expectMethod($user, 'belongsToTeam')->andReturn(true);
    expectMethod($user, 'ownsTeam')->andReturn(true);
    expectMethod($user, 'hasPermissionTo')->andReturn(true);
    $user->id = '1';

    return $user;
}

describe('Job execute coverage — Filament resources', function (): void {
    test('tutti i getFormSchemaOld eseguono lo schema', function (): void {
        $classi = [
            FailedJobResource::class,
            JobBatchResource::class,
            JobResource::class,
            ExportResource::class,
            FailedImportRowResource::class,
            JobManagerResource::class,
            ImportResource::class,
            JobsWaitingResource::class,
        ];

        foreach ($classi as $classe) {
            $schema = $classe::getFormSchemaOld();
            Assert::assertIsArray($schema);
            Assert::assertNotEmpty($classe::getPages());
            Assert::assertTrue(class_exists($classe::getModel()));
        }
    });
});

describe('Job execute coverage — policies', function (): void {
    test('JobBasePolicy before apre super-admin e lascia gli altri', function (): void {
        $policy = new ResultPolicy;

        Assert::assertTrue($policy->before(jobUser(true), 'viewAny'));
        Assert::assertNull($policy->before(jobUser(false), 'viewAny'));
    });

    test('policy foglia si istanziano e before gira su tutte', function (): void {
        foreach ([
            FailedJobPolicy::class,
            JobPolicy::class,
            SchedulePolicy::class,
            TaskPolicy::class,
        ] as $class) {
            $policy = new $class;
            Assert::assertNull($policy->before(jobUser(false), 'update'));
            Assert::assertTrue($policy->before(jobUser(true), 'delete'));
        }
    });
});

describe('Job execute coverage — Task e notification', function (): void {
    test('compileParameters gestisce null, json e formatter scheduler', function (): void {
        $task = new Task;
        Assert::assertSame([], $task->compileParameters());

        $task->parameters = json_encode(['env' => true, 'name' => 'foo'], JSON_THROW_ON_ERROR);
        Assert::assertSame(['env' => true, 'name' => 'foo'], $task->compileParameters(false));
        Assert::assertSame(['env' => '1', 'name' => 'foo'], $task->compileParameters(true));
    });

    test('accessor e routeNotification non toccano il database', function (): void {
        $task = new Task;
        $task->is_active = 1;
        $task->notification_email_address = 'a@b.c';
        $task->notification_phone_number = '333';
        $task->notification_slack_webhook = 'https://hooks.slack.test';

        Assert::assertTrue($task->activated);
        Assert::assertSame('preso', $task->upcoming);
        Assert::assertSame('a@b.c', $task->routeNotificationForMail());
        Assert::assertSame('333', $task->routeNotificationForNexmo());
        Assert::assertSame('https://hooks.slack.test', $task->routeNotificationForSlack());
    });

    test('TaskCompleted via e toMail coprono i canali configurati', function (): void {
        $notification = new TaskCompleted('done');

        $empty = new Task;
        $empty->notification_email_address = null;
        $empty->notification_phone_number = null;
        $empty->notification_slack_webhook = '0';
        Assert::assertSame([], $notification->via($empty));

        $full = new Task;
        $full->description = 'Nightly';
        $full->notification_email_address = 'ops@example.com';
        $full->notification_phone_number = '111';
        $full->notification_slack_webhook = 'https://hooks.example';
        Assert::assertSame(['mail', 'nexmo', 'slack'], $notification->via($full));

        $mail = $notification->toMail($full);
        Assert::assertNotEmpty($mail->subject);
    });

    test('autoCleanup no-op quando num è zero', function (): void {
        $task = new Task;
        $task->auto_cleanup_num = 0;
        $task->autoCleanup();
        Assert::assertSame(0, $task->auto_cleanup_num);
    });
});

describe('Job execute coverage — events request rules columns', function (): void {
    test('eventi di broadcast espongono i canali', function (): void {
        Assert::assertSame('public', (new PublicEvent)->broadcastOn()->name);
        Assert::assertStringContainsString('private.', (new PrivateEvent('ciao'))->broadcastOn()->name);

        $task = new Task;
        $event = new BroadcastingEvent($task);
        Assert::assertStringContainsString('task.events', $event->broadcastOn()->name);
        Assert::assertTrue($event->broadcastWhen());
    });

    test('ScheduleRequest authorize rules attributes messages e merge', function (): void {
        $request = ScheduleRequest::create('/job/schedules', 'POST', []);
        $request->setContainer(app())->setRedirector(app('redirect'));

        Assert::assertTrue($request->authorize());
        Assert::assertArrayHasKey('command', $request->rules());
        Assert::assertArrayHasKey('command', $request->attributes());
        Assert::assertArrayHasKey('groups.regex', $request->messages());
    });

    test('Corn valida espressione cron e rifiuta valori non stringa', function (): void {
        $rule = new Corn;
        $failed = false;
        $rule->validate('expression', ['not-string'], static function (string $message, ?string $attribute = null) use (&$failed): PotentiallyTranslatedString {
            $failed = true;

            return new PotentiallyTranslatedString($message, app(Translator::class));
        });
        Assert::assertTrue($failed);

        $failed = false;
        $rule->validate('expression', 'not a cron', static function (string $message, ?string $attribute = null) use (&$failed): PotentiallyTranslatedString {
            $failed = true;

            return new PotentiallyTranslatedString($message, app(Translator::class));
        });
        Assert::assertTrue($failed);

        $failed = false;
        $rule->validate('expression', '* * * * *', static function (string $message, ?string $attribute = null) use (&$failed): PotentiallyTranslatedString {
            $failed = true;

            return new PotentiallyTranslatedString($message, app(Translator::class));
        });
        Assert::assertFalse($failed);
    });

    test('ActionGroup getActions è vuoto ma eseguito', function (): void {
        $group = ActionGroup::make([]);
        Assert::assertSame([], $group->getActions());
    });
});

describe('Job execute coverage — actions enums commands livewire', function (): void {
    test('DummyAction e GetCommandsAction eseguono', function (): void {
        ob_start();
        (new DummyAction)->execute();
        $out = (string) ob_get_clean();
        Assert::assertStringContainsString('hello', $out);

        jobBindArtisan();
        $commands = (new GetCommandsAction)->execute();
        Assert::assertGreaterThan(0, $commands->count());
    });

    test('Status enum espone label color icon tramite EnumTrait', function (): void {
        foreach (Status::cases() as $case) {
            Assert::assertNotSame('', $case->getLabel());
            Assert::assertNotSame('', $case->getColor());
            Assert::assertNotSame('', $case->getIcon());
        }
    });

    test('FormatSeconds copre giorni ore minuti secondi', function (): void {
        $probe = new class
        {
            use FormatSeconds;
        };

        Assert::assertStringContainsString('d', $probe->formatSeconds(90061));
        Assert::assertSame('1 m 0 s', $probe->formatSeconds(60));
        Assert::assertSame('', $probe->formatSeconds(0));
    });

    test('artisan phpunit:test e schedule:test-job eseguono handle', function (): void {
        $phpunit = $this->artisan('phpunit:test', ['argument' => 'x']);
        $schedule = $this->artisan('schedule:test-job');
        Assert::assertInstanceOf(PendingCommand::class, $phpunit);
        Assert::assertInstanceOf(PendingCommand::class, $schedule);
        $phpunit->assertExitCode(0);
        $schedule->assertExitCode(0);
    });

    test('Http/Livewire e resources/views/livewire sono ritirati (nessuna eccezione)', function (): void {
        Assert::assertFalse(class_exists('Modules\\Job\\Http\\Livewire\\Broad', false));
        Assert::assertFalse(class_exists('Modules\\Job\\Http\\Livewire\\Job\\Status', false));
        Assert::assertFalse(class_exists('Modules\\Job\\Http\\Livewire\\Schedule\\Crud', false));
        Assert::assertFalse(class_exists('Modules\\Job\\Http\\Livewire\\Schedule\\Status', false));
        Assert::assertDirectoryDoesNotExist(base_path('Modules/Job/app/Http/Livewire'));
        Assert::assertDirectoryDoesNotExist(base_path('Modules/Job/resources/views/livewire'));
    });

    test('modelli foglia espongono tabella', function (): void {
        Assert::assertSame('jobs', (new Job)->getTable());
        Assert::assertSame('failed_jobs', (new FailedJob)->getTable());
        Assert::assertSame('job_batches', (new JobBatch)->getTable());
        Assert::assertSame('schedules', (new Schedule)->getTable());
        Assert::assertSame('results', (new Result)->getTable());
    });

    test('policy CRUD con Team e hasPermissionTo', function (): void {
        $user = jobUser(false);
        $team = new Team;

        $failed = new FailedJobPolicy;
        Assert::assertFalse($failed->viewAny($user));
        Assert::assertTrue($failed->view($user, $team));
        Assert::assertTrue($failed->create($user));
        Assert::assertFalse($failed->update($user));
        Assert::assertTrue($failed->addTeamMember($user, $team));
        Assert::assertTrue($failed->updateTeamMember($user, $team));
        Assert::assertTrue($failed->removeTeamMember($user, $team));
        Assert::assertTrue($failed->delete($user, $team));

        $jobPolicy = new JobPolicy;
        Assert::assertFalse($jobPolicy->viewAny($user));
        Assert::assertTrue($jobPolicy->view($user, $team));
        Assert::assertTrue($jobPolicy->create($user));
        Assert::assertFalse($jobPolicy->update($user));
        Assert::assertTrue($jobPolicy->delete($user, $team));

        $batch = new JobBatchPolicy;
        Assert::assertFalse($batch->viewAny($user));
        Assert::assertTrue($batch->create($user));
        Assert::assertFalse($batch->update($user));

        $schedule = new Schedule;
        $schedulePolicy = new SchedulePolicy;
        Assert::assertTrue($schedulePolicy->viewAny($user));
        Assert::assertTrue($schedulePolicy->view($user, $schedule));
        Assert::assertTrue($schedulePolicy->create($user));
        Assert::assertTrue($schedulePolicy->update($user, $schedule));
        Assert::assertTrue($schedulePolicy->delete($user, $schedule));
        Assert::assertTrue($schedulePolicy->restore($user, $schedule));
        Assert::assertTrue($schedulePolicy->forceDelete($user, $schedule));

        $comment = new TaskComment;
        $commentPolicy = new TaskCommentPolicy;
        $commentPolicy->viewAny($user);
        $commentPolicy->view($user, $comment);
        $commentPolicy->create($user);
        $commentPolicy->update($user, $comment);
        $commentPolicy->delete($user, $comment);
        $commentPolicy->restore($user, $comment);
        $commentPolicy->forceDelete($user, $comment);

        $historyPolicy = new ScheduleHistoryPolicy;
        $history = new ScheduleHistory;
        foreach (['viewAny', 'create'] as $m) {
            if (method_exists($historyPolicy, $m)) {
                $historyPolicy->{$m}($user);
            }
        }
        foreach (['view', 'update', 'delete', 'restore', 'forceDelete'] as $m) {
            if (method_exists($historyPolicy, $m)) {
                $historyPolicy->{$m}($user, $history);
            }
        }
    });

    test('FrontendSortable Job accessors Result e ScheduleObserver', function (): void {
        $q = Task::query()->sortableBy(['description'], ['description' => 'asc']);
        Assert::assertInstanceOf(Builder::class, $q);

        $job = new Job;
        $job->setRawAttributes(['reserved_at' => 10, 'payload' => json_encode(['displayName' => 'Foo'], JSON_THROW_ON_ERROR)]);
        Assert::assertSame('running', $job->status);
        Assert::assertSame('Foo', $job->display_name);

        $waiting = new Job;
        $waiting->setRawAttributes(['reserved_at' => null, 'payload' => json_encode(['displayName' => 'Bar'], JSON_THROW_ON_ERROR)]);
        Assert::assertSame('waiting', $waiting->status);

        $result = new Result;
        $result->getLastRun();
        $result->getAverageRunTime();

        config(['job::cache.enabled' => false]);
        $observer = new ScheduleObserver;
        $observer->created();
        $observer->updated(new Schedule);
        $observer->saved(new Schedule);
    });
});
