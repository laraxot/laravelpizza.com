<?php

declare(strict_types=1);
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Actions\LogUserLogoutAction;
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

    Assert::assertNull($activity->causer_id);
});

test('LogUserLoginAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogUserLoginAction;

    $activity = $action->execute($user);

    Assert::assertSame('login', $activity->event);
});

test('LogUserLogoutAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogUserLogoutAction;

    $activity = $action->execute($user);

    Assert::assertSame('logout', $activity->event);
});

test('LogModelCreatedAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogModelCreatedAction;

    $activity = $action->execute($user);

    Assert::assertSame('created', $activity->event);
});

test('LogModelUpdatedAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogModelUpdatedAction;

    $activity = $action->execute($user);

    Assert::assertSame('updated', $activity->event);
});

test('LogModelDeletedAction can execute', function () {
    $user = UserFactory::new()->createOne(['name' => 'Test User', 'password' => 'password']);

    $action = new LogModelDeletedAction;

    $activity = $action->execute($user);

    Assert::assertSame('deleted', $activity->event);
});
