<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventPerformer;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

test('event performer model can be instantiated', function () {
    $eventPerformer = EventPerformer::factory()->create();
    expect($eventPerformer)->toBeInstanceOf(EventPerformer::class)
        ->and($eventPerformer->id)->not->toBeNull();
});

test('event performer has correct fillable fields', function () {
    $eventPerformer = new EventPerformer();
    $fillable = ['event_id', 'user_id'];
    
    foreach ($fillable as $field) {
        expect(in_array($field, $eventPerformer->getFillable()))->toBeTrue();
    }
});

test('event performer can be created with event and user', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    
    $eventPerformer = EventPerformer::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
    ]);

    expect($eventPerformer->event_id)->toBe($event->id)
        ->and($eventPerformer->user_id)->toBe($user->id);
});

test('event performer uses correct table name', function () {
    $eventPerformer = new EventPerformer();
    expect($eventPerformer->getTable())->toBe('event_performer');
});

test('event performer factory creates valid instances', function () {
    $eventPerformer = EventPerformer::factory()->create();
    
    expect($eventPerformer->event_id)->not->toBeNull()
        ->and($eventPerformer->user_id)->not->toBeNull();
});

test('event performer can be queried from database', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    
    EventPerformer::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
    ]);

    $found = EventPerformer::where('event_id', $event->id)
        ->where('user_id', $user->id)
        ->first();

    expect($found)->not->toBeNull()
        ->and($found->event_id)->toBe($event->id);
});

test('event performer extends xot base pivot', function () {
    $eventPerformer = new EventPerformer();
    expect($eventPerformer)->toBeInstanceOf(\Modules\Xot\Models\XotBasePivot::class);
});

test('multiple event performers can be created for same event', function () {
    $event = Event::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    EventPerformer::factory()->createMany([
        ['event_id' => $event->id, 'user_id' => $user1->id],
        ['event_id' => $event->id, 'user_id' => $user2->id],
    ]);

    $eventPerformers = EventPerformer::where('event_id', $event->id)->get();
    expect($eventPerformers)->toHaveCount(2);
});
