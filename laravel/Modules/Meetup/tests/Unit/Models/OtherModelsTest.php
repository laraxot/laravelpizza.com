<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventPerformer;
use Modules\Meetup\Models\EventSponsor;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

test('event user model works', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();
    
    $eventUser = EventUser::create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'attending',
    ]);

    expect($eventUser->user_id)->toBe($user->id)
        ->and($eventUser->event_id)->toBe($event->id);
});

test('event performer model works', function () {
    $event = Event::factory()->create();
    
    $performer = EventPerformer::create([
        'event_id' => $event->id,
        'name' => 'John Performer',
        'type' => 'speaker',
    ]);

    expect($performer->event_id)->toBe($event->id)
        ->and($performer->name)->toBe('John Performer');
});

test('event sponsor model works', function () {
    $event = Event::factory()->create();
    
    $sponsor = EventSponsor::create([
        'event_id' => $event->id,
        'name' => 'Acme Corp',
        'level' => 'gold',
    ]);

    expect($sponsor->event_id)->toBe($event->id)
        ->and($sponsor->name)->toBe('Acme Corp');
});
