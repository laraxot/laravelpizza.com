<?php

declare(strict_types=1);

use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LogActivityAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogActivityAction(
        type: 'test_event',
        user: $user,
        description: 'Test Description'
    );

    $activity = $action->execute();

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('test_event', $activity->event);
    Assert::assertSame('Test Description', $activity->description);
});

test('LogActivityAction handles null user', function () {
    $action = new LogActivityAction(
        type: 'test_event',
        user: null,
        description: 'Test Description'
    );

    $activity = $action->execute();

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertNull($activity->causer_id);
});

test('LogUserLoginAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogUserLoginAction($user);

    $activity = $action->execute();

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('login', $activity->event);
});

test('LogUserLogoutAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogUserLogoutAction($user);

    $activity = $action->execute();

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('logout', $activity->event);
});

test('LogModelCreatedAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogModelCreatedAction($user);

    $activity = $action->execute();

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('created', $activity->event);
});

test('LogModelUpdatedAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogModelUpdatedAction($user);

    $activity = $action->execute();

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('updated', $activity->event);
});

test('LogModelDeletedAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogModelDeletedAction($user);

    $activity = $action->execute();

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('deleted', $activity->event);
});
