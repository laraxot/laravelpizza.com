<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\ProposeMeetupAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it creates event with pending status', function () {
    $event = app(ProposeMeetupAction::class)->execute([
        'title' => 'Nuova Pizzata '.uniqid(),
        'slug' => 'nuova-pizzata-'.uniqid(),
        'description' => 'Una bellissima pizzata Laravel',
        'max_attendees' => 30,
        'start_date' => now()->addDays(30),
    ], '42');

    expect($event)->toBeInstanceOf(Event::class)
        ->and($event->status)->toBe('pending')
        ->and($event->attendees_count)->toBe(0)
        ->and((string) $event->user_id)->toBe('42')
        ->and((string) $event->organizer_id)->toBe('42');
});

test('pending event is not visible via published scope', function () {
    $event = app(ProposeMeetupAction::class)->execute([
        'title' => 'Pending Pizzata '.uniqid(),
        'slug' => 'pending-'.uniqid(),
        'max_attendees' => 20,
    ], '99');

    $found = Event::query()
        ->where('id', $event->id)
        ->where('status', 'published')
        ->first();

    expect($found)->toBeNull();
});

test('pending event is visible to its proposer', function () {
    $proposerId = '77';

    $event = app(ProposeMeetupAction::class)->execute([
        'title' => 'Proposer Pizzata '.uniqid(),
        'slug' => 'proposer-'.uniqid(),
        'max_attendees' => 20,
    ], $proposerId);

    $found = Event::query()
        ->where('id', $event->id)
        ->where('user_id', $proposerId)
        ->where('status', 'pending')
        ->first();

    expect($found)->not->toBeNull()
        ->and((string) $found->user_id)->toBe($proposerId);
});
