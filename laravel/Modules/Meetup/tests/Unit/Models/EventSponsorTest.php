<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

test('event sponsor model can be instantiated', function () {
    $eventSponsor = EventSponsor::factory()->create();
    expect($eventSponsor)->toBeInstanceOf(EventSponsor::class)
        ->and($eventSponsor->id)->not->toBeNull();
});

test('event sponsor has correct fillable fields', function () {
    $eventSponsor = new EventSponsor();
    $fillable = ['event_id', 'user_id'];
    
    foreach ($fillable as $field) {
        expect(in_array($field, $eventSponsor->getFillable()))->toBeTrue();
    }
});

test('event sponsor can be created with event and user', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    
    $eventSponsor = EventSponsor::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
    ]);

    expect($eventSponsor->event_id)->toBe($event->id)
        ->and($eventSponsor->user_id)->toBe($user->id);
});

test('event sponsor uses correct table name', function () {
    $eventSponsor = new EventSponsor();
    expect($eventSponsor->getTable())->toBe('event_sponsor');
});

test('event sponsor factory creates valid instances', function () {
    $eventSponsor = EventSponsor::factory()->create();
    
    expect($eventSponsor->event_id)->not->toBeNull()
        ->and($eventSponsor->user_id)->not->toBeNull();
});

test('event sponsor can be queried from database', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    
    EventSponsor::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
    ]);

    $found = EventSponsor::where('event_id', $event->id)
        ->where('user_id', $user->id)
        ->first();

    expect($found)->not->toBeNull()
        ->and($found->event_id)->toBe($event->id);
});

test('event sponsor extends xot base pivot', function () {
    $eventSponsor = new EventSponsor();
    expect($eventSponsor)->toBeInstanceOf(\Modules\Xot\Models\XotBasePivot::class);
});

test('multiple event sponsors can be created for same event', function () {
    $event = Event::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    EventSponsor::factory()->createMany([
        ['event_id' => $event->id, 'user_id' => $user1->id],
        ['event_id' => $event->id, 'user_id' => $user2->id],
    ]);

    $eventSponsors = EventSponsor::where('event_id', $event->id)->get();
    expect($eventSponsors)->toHaveCount(2);
});
