<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Modules\Activity\Listeners\LogoutListener;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('logout listener is registered for logout event', function () {
    Event::fake();
    
    Event::assertListening(
        Logout::class,
        LogoutListener::class
    );
});

test('logout listener handles logout event and creates activity', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    $event = new Logout('web', $user);

    $listener = new LogoutListener();
    $listener->handle($event);

    $activity = Activity::where('causer_type', User::class)
        ->where('causer_id', $user->id)
        ->where('event', 'logout')
        ->first();

    \assert($activity instanceof Activity);
    expect($activity)->not->toBeNull();
    expect($activity->description)->toContain('logout');
    expect($activity->causer_id)->toBe($user->id);
    expect($activity->causer_type)->toBe(User::class);
    expect($activity->properties)->toHaveKey('guard', 'web');
});

test('logout listener creates activity with correct properties', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    $event = new Logout('api', $user);


    $listener = new LogoutListener();
    $listener->handle($event);

    $activity = Activity::where('causer_id', $user->id)->latest()->first();
    \assert($activity instanceof Activity);

    expect($activity->properties)
        ->toHaveKey('guard', 'api')
        ->toHaveKey('ip_address')
        ->toHaveKey('user_agent')
        ->toHaveKey('timestamp');
});

test('logout listener handles multiple logout events correctly', function () {
    $user1 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user1 instanceof User);
    $user2 = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user2 instanceof User);


    $event1 = new Logout('web', $user1);
    $event2 = new Logout('api', $user2);

    $listener = new LogoutListener;
    $listener->handle($event1);
    $listener->handle($event2);

    $activities = Activity::whereIn('causer_id', [$user1->id, $user2->id])->get();

    expect($activities)->toHaveCount(2);

    $user1Activity = $activities->where('causer_id', $user1->id)->first();
    \assert($user1Activity instanceof Activity);
    $user2Activity = $activities->where('causer_id', $user2->id)->first();
    \assert($user2Activity instanceof Activity);

    expect($user1Activity->properties['guard'])->toBe('web');
    expect($user2Activity->properties['guard'])->toBe('api');
});

test('logout listener includes session duration when available', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);


    $loginTime = now()->subHours(2);
    $user->last_login_at = $loginTime;
    $user->save();

    $event = new Logout('web', $user);

    $listener = new LogoutListener();
    $listener->handle($event);

    $activity = Activity::where('causer_id', $user->id)->first();
    \assert($activity instanceof Activity);

    expect($activity->properties)->toHaveKey('session_duration');
    expect($activity->properties['session_duration'])->toBeGreaterThanOrEqual(7200);
});

test('logout listener uses correct log name for activities', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    $event = new Logout('web', $user);


    $listener = new LogoutListener();
    $listener->handle($event);

    $activity = Activity::where('causer_id', $user->id)->first();
    \assert($activity instanceof Activity);

    expect($activity->log_name)->toBe('auth');
});

test('logout listener handles event without user gracefully', function () {
    $event = new Logout('web', null);
    

    $listener = new LogoutListener();

    expect(fn () => $listener->handle($event))->not->toThrow(Exception::class);
    
    $activities = Activity::where('event', 'logout')->get();
    expect($activities)->toBeEmpty();
});

test('logout listener creates unique activities for same user different sessions', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);


    $event1 = new Logout('web', $user);
    $event2 = new Logout('api', $user);

    $listener = new LogoutListener();
    $listener->handle($event1);
    $listener->handle($event2);

    $activities = Activity::where('causer_id', $user->id)->get();

    expect($activities)->toHaveCount(2);

    $firstActivity = $activities->first();
    \assert($firstActivity instanceof Activity);
    $lastActivity = $activities->last();
    \assert($lastActivity instanceof Activity);

    expect($firstActivity->properties['guard'])->toBe('web');
    expect($lastActivity->properties['guard'])->toBe('api');
    expect($firstActivity->id)->not->toBe($lastActivity->id);
});

test('logout listener tracks logout reason when provided', function () {
    $user = User::factory()->create(); // @phpstan-ignore-line method.nonObject
    \assert($user instanceof User);
    $event = new Logout('web', $user);


    // Assuming implementation checks request()
    request()->merge(['logout_reason' => 'user_initiated']);

    $listener = new LogoutListener();
    $listener->handle($event);

    $activity = Activity::where('causer_id', $user->id)->first();
    \assert($activity instanceof Activity);

    expect($activity->properties)->toHaveKey('logout_reason', 'user_initiated');
});

test('logout listener handles concurrent logout events', function () {
    $users = User::factory()->count(5)->create(); // @phpstan-ignore-line method.nonObject
    \assert($users instanceof \Illuminate\Database\Eloquent\Collection);


    $events = $users->map(fn ($user) => new Logout('web', $user));

    $listener = new LogoutListener;

    foreach ($events as $event) {
        \assert($event instanceof Logout);
        $listener->handle($event);
    }

    $activities = Activity::where('event', 'logout')->get();

    expect($activities)->toHaveCount(5);

    $userIds = $activities->pluck('causer_id')->unique();
    expect($userIds)->toHaveCount(5);
});
