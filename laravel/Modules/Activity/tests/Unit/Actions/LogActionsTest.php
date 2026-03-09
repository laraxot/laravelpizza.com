<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Actions\LogUserLoginAction;
use Modules\Activity\Actions\LogUserLogoutAction;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;

test('LogActivityAction can execute', function () {
    $user = User::factory()->create(['name' => 'Test User', 'password' => 'password']);

    $action = new LogActivityAction(
        type: 'test_event',
        user: $user,
        subject: null,
        properties: ['key' => 'value'],
        description: 'Test Description'
    );

    $activity = $action->execute();

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->event)->toBe('test_event')
        ->and($activity->description)->toBe('Test Description');
});

test('LogActivityAction throws exception for empty type', function () {
    $this->expectException(\InvalidArgumentException::class);

    new LogActivityAction(
        type: '',
        user: null,
        subject: null,
        properties: null,
        description: 'Test Description'
    );
});

test('LogUserLoginAction can execute', function () {
    $user = User::factory()->create(['name' => 'Test User', 'password' => 'password']);

    $action = new LogUserLoginAction($user);

    $activity = $action->execute();

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->event)->toBe('login');
});

test('LogUserLogoutAction can execute', function () {
    $user = User::factory()->create(['name' => 'Test User', 'password' => 'password']);

    $action = new LogUserLogoutAction($user);

    $activity = $action->execute();

    expect($activity)->toBeInstanceOf(Activity::class)
        ->and($activity->event)->toBe('logout');
});

test('LogModelCreatedAction can execute', function () {
    $user = User::factory()->create(['name' => 'Test User', 'password' => 'password']);
    $model = User::factory()->create(['name' => 'Subject User', 'password' => 'password']);

    $action = new LogModelCreatedAction($model, $user);

    $result = $action->execute();

    expect($result)->toBeInstanceOf(Activity::class)
        ->and($result->event)->toBe('created');
});

test('LogModelUpdatedAction can execute', function () {
    $user = User::factory()->create(['name' => 'Test User', 'password' => 'password']);
    $model = User::factory()->create(['name' => 'Subject User', 'password' => 'password']);

    $action = new LogModelUpdatedAction($model, $user);

    $result = $action->execute();

    expect($result)->toBeInstanceOf(Activity::class)
        ->and($result->event)->toBe('updated');
});

test('LogModelDeletedAction can execute', function () {
    $user = User::factory()->create(['name' => 'Test User', 'password' => 'password']);
    $model = User::factory()->create(['name' => 'Subject User', 'password' => 'password']);

    $action = new LogModelDeletedAction($model, $user);

    $result = $action->execute();

    expect($result)->toBeInstanceOf(Activity::class)
        ->and($result->event)->toBe('deleted');
});
