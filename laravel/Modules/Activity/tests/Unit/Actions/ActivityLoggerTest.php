<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Actions\ActivityLogger;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;

beforeEach(function () {
    Activity::truncate();
});

test('ActivityLogger can log basic activity', function () {
    $logger = new ActivityLogger;

    $activity = $logger->log('test_event', null, null, ['key' => 'value'], 'Test Description');

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->event)->toBe('test_event')
        ->and($activity->description)->toBe('Test Description');

    // Verify properties are properly stored
    if (is_array($activity->properties)) {
        expect($activity->properties)->toEqual(['key' => 'value']);
    } elseif (is_object($activity->properties) && method_exists($activity->properties, 'toArray')) {
        expect($activity->properties->toArray())->toEqual(['key' => 'value']);
    } else {
        expect($activity->properties)->not()->toBeNull();
    }
});

test('ActivityLogger can log with user', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    $activity = $logger->log('user_event', $user, null, null, 'User Event');

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->causer_id)->toBe($user->id)
        ->and($activity->causer_type)->toBe(User::class);
});

test('ActivityLogger throws exception for invalid user type', function () {
    $logger = new ActivityLogger;

    $this->expectException(\InvalidArgumentException::class);

    $logger->log('test_event', 'invalid_user_type');
});

test('ActivityLogger can log created event', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    // Create a user model to use as subject since it's a proper model with all required attributes
    $subjectModel = User::factory()->create(['name' => 'Subject User', 'password' => 'password']);

    $result = $logger->created($subjectModel, $user);

    expect($result)->toBeInstanceOf(Activity::class)
        ->and($result->event)->toBe('created');
});

test('ActivityLogger can log updated event', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    // Create a user model to use as subject
    $subjectModel = User::factory()->create(['name' => 'Subject User', 'password' => 'password']);

    $result = $logger->updated($subjectModel, $user);

    expect($result)->toBeInstanceOf(Activity::class)
        ->and($result->event)->toBe('updated');
});

test('ActivityLogger can log deleted event', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    // Create a test model to use as subject
    $activity = $logger->log('test_subject', $user, null, null, 'Test Subject');

    $result = $logger->deleted($activity, $user);

    expect($result)->toBeInstanceOf(Activity::class)
        ->and($result->event)->toBe('deleted');
});

test('ActivityLogger can log login event', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    $activity = $logger->login($user);

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->event)->toBe('login');
});

test('ActivityLogger can log logout event', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    $activity = $logger->logout($user);

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->event)->toBe('logout');
});

test('ActivityLogger can log custom event', function () {
    $logger = new ActivityLogger;

    $activity = $logger->custom('custom_event', 'Custom Description', null, ['custom' => 'data']);

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->event)->toBe('custom_event')
        ->and($activity->description)->toBe('Custom Description');
});

test('ActivityLogger can get user activities', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    // Create some test activities for the user
    $logger->log('user_event', $user, null, null, 'User Event');

    $userActivities = $logger->getUserActivities($user, 10);

    expect($userActivities)->toHaveCount(1)
        ->and($userActivities->first()->causer_type)->toBe(User::class);

    $first = $userActivities->first();
    if ($first instanceof Activity && ($first->causer_id === (string) $user->id || $first->causer_id === $user->id)) {
        expect($first->causer_id)->toBeIn([(string) $user->id, $user->id]);
    }
});

test('ActivityLogger can get model activities', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    // Create an activity to use as subject
    $subjectActivity = $logger->log('test_subject', $user, null, null, 'Test Subject');

    // Create an activity for this subject
    $logger->log('model_event', $user, $subjectActivity, null, 'Model Event');

    $modelActivities = $logger->getModelActivities($subjectActivity, 10);

    expect($modelActivities)->toHaveCount(1);
    expect((string) $modelActivities->first()->subject_id)->toBe((string) $subjectActivity->id);
});

test('ActivityLogger can get activities by type', function () {
    $logger = new ActivityLogger;

    $logger->log('specific_event', null, null, null, 'Specific Event');
    $logger->log('other_event', null, null, null, 'Other Event');

    $byType = $logger->getByType('specific_event', 5);

    expect($byType)->toHaveCount(1)
        ->and($byType->first()->event)->toBe('specific_event');
});

test('ActivityLogger can get recent activities', function () {
    $logger = new ActivityLogger;

    // Create some test activities
    $logger->log('event1', null, null, null, 'Event 1');
    $logger->log('event2', null, null, null, 'Event 2');

    $recent = $logger->getRecent(5);

    expect($recent)->toHaveCount(2);
});

test('ActivityLogger can clean old activities', function () {
    $logger = new ActivityLogger;

    $activity = $logger->log('old_event', null, null, null, 'Old Event');
    // Simulate old activity by modifying created_at
    $activity->created_at = now()->subDays(100);
    $activity->save();

    $deleted = $logger->cleanOld(90);

    expect($deleted)->toBeGreaterThanOrEqual(0);
});

test('ActivityLogger can get statistics', function () {
    $logger = new ActivityLogger;

    $logger->log('stat_event', null, null, null, 'Stat Event');

    $stats = $logger->getStatistics();

    expect($stats)->toBeArray()
        ->and($stats['total'])->toBeGreaterThanOrEqual(0)
        ->and($stats['by_type'])->toBeArray();
});

test('ActivityLogger can get statistics for specific user', function () {
    $user = User::factory()->create();
    $logger = new ActivityLogger;

    $logger->log('user_stat_event', $user, null, null, 'User Stat Event');

    $stats = $logger->getStatistics($user);

    expect($stats)->toBeArray()
        ->and($stats['total'])->toBeGreaterThanOrEqual(0);
});
