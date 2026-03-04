<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

test('event user model can be instantiated', function () {
    $eventUser = EventUser::factory()->create();
    expect($eventUser)->toBeInstanceOf(EventUser::class)
        ->and($eventUser->id)->not->toBeNull();
});

test('event user has correct fillable fields', function () {
    $eventUser = new EventUser();
    $fillable = ['event_id', 'user_id'];
    
    foreach ($fillable as $field) {
        expect(in_array($field, $eventUser->getFillable()))->toBeTrue();
    }
});

test('event user can be created with event and user', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    
    $eventUser = EventUser::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
    ]);

    expect($eventUser->event_id)->toBe($event->id)
        ->and($eventUser->user_id)->toBe($user->id);
});

test('event user uses correct table name', function () {
    $eventUser = new EventUser();
    expect($eventUser->getTable())->toBe('event_user');
});

test('event user factory creates valid instances', function () {
    $eventUser = EventUser::factory()->create();
    
    expect($eventUser->event_id)->not->toBeNull()
        ->and($eventUser->user_id)->not->toBeNull();
});

test('event user can be queried from database', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    
    EventUser::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
    ]);

    $found = EventUser::where('event_id', $event->id)
        ->where('user_id', $user->id)
        ->first();

    expect($found)->not->toBeNull()
        ->and($found->event_id)->toBe($event->id);
});

test('event user extends xot base pivot', function () {
    $eventUser = new EventUser();
    expect($eventUser)->toBeInstanceOf(\Modules\Xot\Models\XotBasePivot::class);
});

test('multiple event users can be created for same event', function () {
    $event = Event::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    EventUser::factory()->createMany([
        ['event_id' => $event->id, 'user_id' => $user1->id],
        ['event_id' => $event->id, 'user_id' => $user2->id],
    ]);

    $eventUsers = EventUser::where('event_id', $event->id)->get();
    expect($eventUsers)->toHaveCount(2);
});

test('event user timestamps are automatically set', function () {
    $eventUser = EventUser::factory()->create();
    
    expect($eventUser->created_at)->not->toBeNull()
        ->and($eventUser->updated_at)->not->toBeNull();
});

test('event user can be updated', function () {
    $eventUser = EventUser::factory()->create();
    $newUser = User::factory()->create();
    
    $eventUser->update(['user_id' => $newUser->id]);
    
    expect($eventUser->fresh()->user_id)->toBe($newUser->id);
});
