<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Logout;
use Modules\Activity\Listeners\LoginListener;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Support\Str;

uses(TestCase::class);

test('login listener handle executes without side effects', function (): void {
    $listener = new LoginListener();

    $before = Activity::query()->count();
    $listener->handle();
    $after = Activity::query()->count();

    expect($after)->toBe($before);
});

test('logout listener returns early when event has no user', function (): void {
    $listener = new LogoutListener();
    $event = new Logout('web', null);

    $before = Activity::query()->count();
    $listener->handle($event);
    $after = Activity::query()->count();

    expect($after)->toBe($before);
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

    $listener = new LogoutListener();
    $listener->handle(new Logout('web', $user));

    $activity = Activity::query()->latest('id')->first();

    expect($activity)->not->toBeNull()
        ->and($activity?->event)->toBe('logout')
        ->and($activity?->log_name)->toBe('auth')
        ->and($activity?->causer_id)->toBe($user->getKey())
        ->and($activity?->properties['guard'] ?? null)->toBe('web')
        ->and($activity?->properties['logout_reason'] ?? null)->toBe('timeout')
        ->and($activity?->properties)->toHaveKey('session_duration');
});
