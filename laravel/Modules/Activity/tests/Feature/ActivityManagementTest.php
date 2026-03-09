<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Modules\Activity\Models\Activity;
use Modules\User\Models\User;

uses(\Modules\Activity\Tests\TestCase::class);

test('user can create activity', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    expect($user)->not->toBeNull();

    $activity = Activity::create([
        'log_name' => 'test',
        'description' => 'Test Description',
        'causer_type' => User::class,
        'causer_id' => $user->id,
    ]);
    \assert($activity instanceof Activity);
    expect($activity)->not->toBeNull();

    expect($activity)
        ->toBeInstanceOf(Activity::class)
        ->and($activity->description)->toBe('Test Description')
        ->and($activity->causer_id)->toBe($user->id);
});

test('activity can be updated', function () {
    $activity = Activity::create([
        'log_name' => 'test',
        'description' => 'Original Description',
    ]);
    \assert($activity instanceof Activity);
    expect($activity)->not->toBeNull();

    $activity->update([
        'description' => 'Updated Description',
    ]);

    $freshActivity = $activity->fresh();
    \assert($freshActivity instanceof Activity);
    expect($freshActivity)->not->toBeNull();
    expect($freshActivity->description)->toBe('Updated Description');
});

test('activity can be deleted', function () {
    $activity = Activity::create([
        'log_name' => 'test',
        'description' => 'Test Description',
    ]);
    \assert($activity instanceof Activity);
    expect($activity)->not->toBeNull();

    $activityId = $activity->id;
    $activity->delete();

    expect(Activity::find($activityId))->toBeNull();
});

test('activity belongs to user', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    expect($user)->not->toBeNull();

    $activity = Activity::create([
        'log_name' => 'test',
        'description' => 'Test Description',
        'causer_type' => User::class,
        'causer_id' => $user->id,
    ]);
    \assert($activity instanceof Activity);
    expect($activity)->not->toBeNull();

    $causer = $activity->causer;
    \assert($causer instanceof User);
    expect($causer)->not->toBeNull()
        ->toBeInstanceOf(User::class);
    expect($causer->id)->toBe($user->id);
});
