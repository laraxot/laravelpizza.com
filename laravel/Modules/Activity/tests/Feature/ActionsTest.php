<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Modules\Activity\Actions\ActivityLogger;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function createUser(): User
{
    return (new UserFactory)->createOne();
}

describe('ActivityLogger', function (): void {
    test('logs simple activity', function (): void {
<<<<<<< .merge_file_YKfYUd
        $user = createActionsTestUser();
=======
        $user = createUser();
>>>>>>> .merge_file_1g7jWy
        $logger = new ActivityLogger;
        $activity = $logger->log('test_event', $user);

        Assert::assertSame('test_event', $activity->event);
        Assert::assertSame($user->id, $activity->causer_id);
    });

    test('logs created event', function (): void {
        $user = createUser();
        $logger = new ActivityLogger;
<<<<<<< .merge_file_YKfYUd
        $model = activityCreateUser();
=======
        $model = TestCase::activityCreateUser();
>>>>>>> .merge_file_1g7jWy

        $activity = $logger->created($model, $user);

        Assert::assertSame('created', $activity->event);
        Assert::assertSame($model->id, $activity->subject_id);
    });
<<<<<<< .merge_file_YKfYUd

    test('logs updated event', function (): void {
        $user = createUser();
        $logger = new ActivityLogger;
        $model = activityCreateUser();

        $activity = $logger->updated($model, $user);

        Assert::assertSame('updated', $activity->event);
        Assert::assertSame($model->id, $activity->subject_id);
    });

    test('logs deleted event', function (): void {
        $user = createUser();
        $logger = new ActivityLogger;
        $model = activityCreateUser();

        $activity = $logger->deleted($model, $user);

        Assert::assertSame('deleted', $activity->event);
        Assert::assertSame($model->id, $activity->subject_id);
    });

    test('logs login event', function (): void {
        $user = createActionsTestUser();
        $logger = new ActivityLogger;
        $activity = $logger->login($user);

        Assert::assertSame('login', $activity->event);
        Assert::assertStringContainsString((string) 'User logged in', (string) $activity->description);
    });

    test('logs logout event', function (): void {
        $user = createActionsTestUser();
        $logger = new ActivityLogger;
        $activity = $logger->logout($user);

        Assert::assertSame('logout', $activity->event);
        Assert::assertStringContainsString((string) 'User logged out', (string) $activity->description);
    });
});

describe('LogActivityAction', function (): void {

    test('creates activity with user', function (): void {
        $user = createActionsTestUser();
        $action = new LogActivityAction(
            type: 'test_type',
            user: $user,
            description: 'Test description'
        );
        $activity = $action->execute();

        Assert::assertSame('test_type', $activity->log_name);
        Assert::assertSame($user->id, $activity->causer_id);
    });
});

describe('LogModelCreatedAction', function (): void {
    test('logs model creation', function (): void {
        $model = activityCreateUser();
        $action = new LogModelCreatedAction(model: $model);
        $activity = $action->execute();

        Assert::assertSame('created', $activity->event);
        Assert::assertSame($model->id, $activity->subject_id);
    });
=======
>>>>>>> .merge_file_1g7jWy
});
