<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Str;
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('login listener handle executes without side effects', function (): void {
    $listener = new LoginListener;

    $before = Activity::query()->count();
    $listener->handle();
    $after = Activity::query()->count();

    Assert::assertSame($before, $after);
});

test('logout listener returns early when event has no user', function (): void {
    $listener = new LogoutListener;
    $user = new User;
    $event = new Logout('web', $user);
    $userProperty = new \ReflectionClass(Logout::class)->getProperty('user');
    $userProperty->setValue($event, null);

    $before = Activity::query()->count();
    $listener->handle($event);
    $after = Activity::query()->count();

    Assert::assertSame($before, $after);
});

test('logout listener creates auth activity with expected properties', function (): void {
    $user = new User([
        'id' => (string) Str::uuid(),
        'name' => 'Listener User',
    ]);
    $user->setAttribute('last_login_at', now()->subMinutes(5)->toDateTimeString());
    $user->exists = true;

    request()->merge([
        'logout_reason' => 'timeout',
    ]);
    request()->server->set('REMOTE_ADDR', '127.0.0.1');
    request()->headers->set('User-Agent', 'Pest');

    $listener = new LogoutListener;
    $listener->handle(new Logout('web', $user));

    $activity = Activity::query()->latest('id')->first();

    Assert::assertNotNull($activity);
    Assert::assertSame('logout', $activity->event);
    Assert::assertSame('auth', $activity->log_name);
    Assert::assertSame($user->getKey(), $activity->causer_id);
    $properties = $activity->properties;
    Assert::assertNotNull($properties);
    $propertiesArray = is_array($properties) ? $properties : $properties->all();
    Assert::assertSame('web', $propertiesArray['guard'] ?? null);
    Assert::assertSame('timeout', $propertiesArray['logout_reason'] ?? null);
    Assert::assertArrayHasKey('session_duration', $propertiesArray);
});
