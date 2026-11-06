<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Activity\Actions\ActivityLogger as ActivityLoggerAction;
use Modules\Activity\Actions\ActivityMaintenanceAction;
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Actions\Query\GetActivitiesByTypeAction;
use Modules\Activity\Actions\Query\GetActivityStatisticsAction;
use Modules\Activity\Actions\Query\GetModelActivitiesAction;
use Modules\Activity\Actions\Query\GetRecentActivitiesAction;
use Modules\Activity\Actions\Query\GetSubjectActivityLogAction;
use Modules\Activity\Actions\Query\GetUserActivitiesAction;
use Modules\Activity\Actions\RecordSubjectActivityAction;
use Modules\Activity\Adapters\ActivityLogger as ActivityLoggerAdapter;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\Fixtures\ActivitySubjectHarness;
use Modules\Activity\Tests\Fixtures\LogActivityActionTestModel;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    config(['cache.default' => 'array']);
});

function activityUnitUser(string $id = 'user-coverage-1'): User
{
    $user = new User;
    $user->forceFill([
        'id' => $id,
        'name' => 'Coverage User',
        'email' => $id.'@example.test',
    ]);
    $user->exists = true;

    return $user;
}

function activityUnitSubject(string $id = 'subj-1'): ActivitySubjectHarness
{
    $subject = new ActivitySubjectHarness;
    $subject->forceFill(['id' => $id, 'name' => 'Subject']);
    $subject->exists = true;

    return $subject;
}

test('LogActivityAction execute persiste con user Auth e subject', function (): void {
    $user = activityUnitUser();
    $subject = new LogActivityActionTestModel(['id' => '99', 'name' => 'X']);
    $subject->exists = true;

    Auth::shouldReceive('id')->never();

    $activity = (new LogActivityAction(
        type: 'custom_evt',
        user: $user,
        subject: $subject,
        properties: ['a' => 1],
        description: 'Desc',
    ))->execute();

    Assert::assertSame('custom_evt', $activity->event);
    Assert::assertSame($user->id, $activity->causer_id);
});

test('LogActivityAction execute usa Auth::id quando user assente', function (): void {
    Auth::shouldReceive('id')->once()->andReturn('auth-from-facade');

    $activity = (new LogActivityAction(type: 'auth_evt'))->execute();

    Assert::assertSame('auth-from-facade', $activity->causer_id);
    Assert::assertNull($activity->causer_type);
});

test('LogModel lifecycle actions e login logout eseguiti', function (): void {
    $user = activityUnitUser('login-user');
    $model = new LogActivityActionTestModel(['id' => '7', 'name' => 'M']);
    $model->exists = true;
    $model->syncOriginal();

    Assert::assertSame('created', (new LogModelCreatedAction($model, $user))->execute()->event);
    Assert::assertSame('updated', (new LogModelUpdatedAction($model, $user))->execute()->event);
    Assert::assertSame('deleted', (new LogModelDeletedAction($model, null))->execute()->event);
    Assert::assertSame('login', (new LogUserLoginAction($user))->execute()->event);
    Assert::assertSame('logout', (new LogUserLogoutAction($user))->execute()->event);
});

test('RecordSubjectActivityAction e query actions coprono execute', function (): void {
    $subject = activityUnitSubject('subj-q');
    $user = activityUnitUser('causer-q');

    $recorded = (new RecordSubjectActivityAction)->execute(
        ActivitySubjectHarness::class,
        $subject->id,
        'recorded',
        ['k' => 'v'],
        'Recorded desc',
    );
    Assert::assertSame('recorded', $recorded->event);

    (new LogActivityAction(
        type: 'login',
        user: $user,
        subject: $subject,
        description: 'u',
    ))->execute();

    Assert::assertGreaterThanOrEqual(1, (new GetRecentActivitiesAction)->execute(10)->count());
    Assert::assertGreaterThanOrEqual(1, (new GetActivitiesByTypeAction)->execute('login', 10)->count());
    Assert::assertGreaterThanOrEqual(1, (new GetModelActivitiesAction)->execute($subject, 10)->count());
    Assert::assertGreaterThanOrEqual(1, (new GetUserActivitiesAction)->execute($user, 10)->count());
    Assert::assertNotEmpty((new GetSubjectActivityLogAction)->execute(ActivitySubjectHarness::class, $subject->id, 50));
});

test('GetActivityStatisticsAction con e senza user e event null', function (): void {
    Activity::create([
        'log_name' => 'default',
        'description' => 'null event',
        'event' => null,
        'properties' => null,
    ]);

    $user = activityUnitUser('stats-user');
    (new LogActivityAction(type: 'stat_type', user: $user, description: 's'))->execute();

    $global = (new GetActivityStatisticsAction)->execute();
    Assert::assertArrayHasKey('total', $global);
    Assert::assertArrayHasKey('by_type', $global);
    Assert::assertArrayHasKey('today', $global);

    $forUser = (new GetActivityStatisticsAction)->execute($user);
    Assert::assertGreaterThanOrEqual(1, $forUser['total']);
});

test('ActivityMaintenanceAction cleanOld e ActivityLogger Action percorsi completi', function (): void {
    Log::spy();

    $user = activityUnitUser('logger-user');
    $model = new LogActivityActionTestModel(['id' => '3', 'name' => 'L']);
    $model->exists = true;
    $model->syncOriginal();

    $logger = new ActivityLoggerAction;

    $logged = $logger->log('evt_log', activityUnitUser('evt-user'), $model, ['p' => 1], 'D');
    Assert::assertSame('evt_log', $logged->event);

    Assert::assertSame('created', $logger->created($model, $user)->event);
    Assert::assertSame('updated', $logger->updated($model, $user)->event);
    Assert::assertSame('deleted', $logger->deleted($model, $user)->event);
    Assert::assertSame('login', $logger->login($user)->event);
    Assert::assertSame('logout', $logger->logout($user)->event);
    Assert::assertSame('custom_type', $logger->custom('custom_type', 'Custom desc', $model, ['x' => 1])->event);

    Assert::assertGreaterThanOrEqual(1, $logger->getUserActivities($user, 20)->count());
    Assert::assertGreaterThanOrEqual(1, $logger->getModelActivities($model, 20)->count());
    Assert::assertGreaterThanOrEqual(1, $logger->getByType('login', 20)->count());
    Assert::assertGreaterThanOrEqual(1, $logger->getRecent(20)->count());

    $stats = $logger->getStatistics($user);
    Assert::assertArrayHasKey('this_week', $stats);
    Assert::assertArrayHasKey('this_month', $stats);

    $statsAll = $logger->getStatistics();
    Assert::assertGreaterThanOrEqual(0, $statsAll['total']);

    $old = Activity::create([
        'log_name' => 'default',
        'description' => 'old',
        'event' => 'old_evt',
    ]);
    Assert::assertNotNull($old->id);
    Activity::query()->whereKey($old->id)->update([
        'created_at' => now()->subDays(120)->toDateTimeString(),
        'updated_at' => now()->subDays(120)->toDateTimeString(),
    ]);

    $deleted = (new ActivityMaintenanceAction)->execute(90);
    Assert::assertGreaterThanOrEqual(1, $deleted);

    $cleaned = $logger->cleanOld(90);
    Assert::assertGreaterThanOrEqual(0, $cleaned);
});

test('ActivityLogger Action log ignora Auth::id non scalare', function (): void {
    \Mockery::close();
    Auth::shouldReceive('id')->once()->andReturn(new \stdClass);

    $activity = (new ActivityLoggerAction)->log('weird_auth', null, null, null, 'W');

    Assert::assertNull($activity->causer_id);
});

test('ActivityLogger Adapter delega log created updated deleted login logout query', function (): void {
    $user = activityUnitUser('adapter-user');
    $model = new LogActivityActionTestModel(['id' => '11', 'name' => 'A']);
    $model->exists = true;
    $model->syncOriginal();

    $adapter = new ActivityLoggerAdapter;

    Assert::assertSame('created', $adapter->created($model, $user)->event);
    Assert::assertSame('updated', $adapter->updated($model, $user)->event);
    Assert::assertSame('deleted', $adapter->deleted($model, $user)->event);
    Assert::assertSame('login', $adapter->login($user)->event);
    Assert::assertSame('logout', $adapter->logout($user)->event);
    Assert::assertSame('ad_custom', $adapter->custom('ad_custom', 'c', $model)->event);

    Assert::assertGreaterThanOrEqual(1, $adapter->getUserActivities($user)->count());
    Assert::assertGreaterThanOrEqual(1, $adapter->getModelActivities($model)->count());
    Assert::assertGreaterThanOrEqual(1, $adapter->getByType('login')->count());
    Assert::assertGreaterThanOrEqual(1, $adapter->getRecent()->count());
    Assert::assertArrayHasKey('total', $adapter->getStatistics($user));
    Assert::assertGreaterThanOrEqual(0, $adapter->cleanOld(3650));
});

test('ActivityLogger Adapter rifiuta user non User', function (): void {
    $invalid = new LogActivityActionTestModel(['name' => 'bad']);

    expect(fn (): Activity => (new ActivityLoggerAdapter)->log('x', $invalid))
        ->toThrow(\InvalidArgumentException::class, 'User must be an instance of User');
});
