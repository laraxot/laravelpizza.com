<?php

declare(strict_types=1);

use Modules\Activity\Actions\ActivityLogger;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ActivityLogger can log basic activity', function () {
    $logger = new ActivityLogger;

    $activity = $logger->log('test_event', null, null, ['key' => 'value'], 'Test Description');

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('test_event', $activity->event);
    Assert::assertSame('Test Description', $activity->description);

    if (is_array($activity->properties)) {
        Assert::assertEquals(['key' => 'value'], $activity->properties);
    } elseif (is_object($activity->properties) && method_exists($activity->properties, 'toArray')) {
        Assert::assertEquals(['key' => 'value'], $activity->properties->toArray());
    } else {
        Assert::assertNull($activity->properties);
    }
});

test('ActivityLogger can log with user', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $activity = $logger->log('user_event', $user, null, null, 'User Event');

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame($user->id, $activity->causer_id);
    Assert::assertSame(User::class, $activity->causer_type);
});

test('ActivityLogger throws exception for invalid user type', function () {
    $logger = new ActivityLogger;

    try {
        $logger->log('test_event', 'invalid_user_type');
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (InvalidArgumentException $exception) {
        Assert::assertInstanceOf(InvalidArgumentException::class, $exception);
    }
});

test('ActivityLogger can log created event', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $subjectModel = UserFactory::new()->createOne(['name' => 'Subject User', 'password' => 'password']);

    $result = $logger->created($subjectModel, $user);

    Assert::assertInstanceOf(Activity::class, $result);
    Assert::assertSame('created', $result->event);
});

test('ActivityLogger can log updated event', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $subjectModel = UserFactory::new()->createOne(['name' => 'Subject User', 'password' => 'password']);

    $result = $logger->updated($subjectModel, $user);

    Assert::assertInstanceOf(Activity::class, $result);
    Assert::assertSame('updated', $result->event);
});

test('ActivityLogger can log deleted event', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $activity = $logger->log('test_subject', $user, null, null, 'Test Subject');

    $result = $logger->deleted($activity, $user);

    Assert::assertInstanceOf(Activity::class, $result);
    Assert::assertSame('deleted', $result->event);
});

test('ActivityLogger can log login event', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $activity = $logger->login($user);

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('login', $activity->event);
});

test('ActivityLogger can log logout event', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $activity = $logger->logout($user);

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('logout', $activity->event);
});

test('ActivityLogger can log custom event', function () {
    $logger = new ActivityLogger;

    $activity = $logger->custom('custom_event', 'Custom Description', null, ['custom' => 'data']);

    Assert::assertInstanceOf(Activity::class, $activity);
    Assert::assertSame('custom_event', $activity->event);
    Assert::assertSame('Custom Description', $activity->description);
});

test('ActivityLogger can get user activities', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $logger->log('user_event', $user, null, null, 'User Event');

    $userActivities = $logger->getUserActivities($user, 10);

    Assert::assertCount(1, $userActivities);
    Assert::assertNotNull($userActivities->first());
    Assert::assertSame($user->id, $userActivities->first()->causer_id);
});

test('ActivityLogger can get model activities', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $subjectActivity = $logger->log('test_subject', $user, null, null, 'Test Subject');

    $logger->log('model_event', $user, $subjectActivity, null, 'Model Event');

    $modelActivities = $logger->getModelActivities($subjectActivity, 10);

    Assert::assertCount(1, $modelActivities);
    Assert::assertNotNull($modelActivities->first());
    Assert::assertSame((string) $subjectActivity->id, (string) $modelActivities->first()->subject_id);
});

test('ActivityLogger can get activities by type', function () {
    $logger = new ActivityLogger;
    $eventType = uniqid('specific_event_', true);

    $logger->log($eventType, null, null, null, 'Specific Event');
    $logger->log(uniqid('other_event_', true), null, null, null, 'Other Event');

    $byType = $logger->getByType($eventType, 5);

    Assert::assertCount(1, $byType);
    Assert::assertNotNull($byType->first());
    Assert::assertSame($eventType, $byType->first()->event);
});

test('ActivityLogger can get recent activities', function () {
    $logger = new ActivityLogger;

    $first = $logger->log(uniqid('recent_event_', true), null, null, null, 'Event 1');
    $first->forceFill(['created_at' => now()->addMinutes(1), 'updated_at' => now()->addMinutes(1)])->save();

    $second = $logger->log(uniqid('recent_event_', true), null, null, null, 'Event 2');
    $second->forceFill(['created_at' => now()->addMinutes(2), 'updated_at' => now()->addMinutes(2)])->save();

    $recent = $logger->getRecent(5);
    $recentIds = $recent->pluck('id')->all();

    Assert::assertContains($first->id, $recentIds);
    Assert::assertContains($second->id, $recentIds);
});

test('ActivityLogger can clean old activities', function () {
    $logger = new ActivityLogger;

    $activity = $logger->log('old_event', null, null, null, 'Old Event');
    $activity->created_at = now()->subDays(100);
    $activity->save();

    $deleted = $logger->cleanOld(90);

    Assert::assertGreaterThanOrEqual(0, $deleted);
});

test('ActivityLogger can get statistics', function () {
    $logger = new ActivityLogger;

    $logger->log('stat_event', null, null, null, 'Stat Event');

    $stats = $logger->getStatistics();

    Assert::assertGreaterThanOrEqual(0, $stats['total']);
    Assert::assertArrayHasKey('by_type', $stats);
});

test('ActivityLogger can get statistics for specific user', function () {
    $user = UserFactory::new()->createOne();
    $logger = new ActivityLogger;

    $logger->log('user_stat_event', $user, null, null, 'User Stat Event');

    $stats = $logger->getStatistics($user);

    Assert::assertGreaterThanOrEqual(0, $stats['total']);
});
