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
    $performer = new EventPerformer();

    expect($performer->getTable())->toBe('event_performer')
        ->and($performer->getFillable())->toContain('event_id')
        ->and($performer->getFillable())->toContain('user_id');
});

test('event sponsor model works', function () {
    $sponsor = new EventSponsor();

    expect($sponsor->getTable())->toBe('event_sponsor')
        ->and($sponsor->getFillable())->toContain('event_id')
        ->and($sponsor->getFillable())->toContain('user_id');
});
