<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\RegisterAttendeeToEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it registers attendee and increments counter', function () {
    $event = Event::query()->create([
        'title' => 'Meetup '.uniqid(),
        'slug' => 'meetup-'.uniqid(),
        'max_attendees' => 10,
        'attendees_count' => 0,
        'status' => 'published',
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    $registration = app(RegisterAttendeeToEventAction::class)->execute($event, 'user-001');

    expect($registration)->toBeInstanceOf(EventUser::class)
        ->and((string) $registration->user_id)->toBe('user-001');

    $event->refresh();
    expect($event->attendees_count)->toBe(1);
});

test('it throws when event is full', function () {
    $event = Event::query()->create([
        'title' => 'Full Meetup '.uniqid(),
        'slug' => 'full-'.uniqid(),
        'max_attendees' => 1,
        'attendees_count' => 1,
        'status' => 'published',
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    expect(fn () => app(RegisterAttendeeToEventAction::class)->execute($event, 'user-002'))
        ->toThrow(\DomainException::class, 'Event is full');
});

test('it throws on duplicate registration', function () {
    $event = Event::query()->create([
        'title' => 'Duplicate Meetup '.uniqid(),
        'slug' => 'dup-'.uniqid(),
        'max_attendees' => 5,
        'attendees_count' => 0,
        'status' => 'published',
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    app(RegisterAttendeeToEventAction::class)->execute($event, 'user-003');

    expect(fn () => app(RegisterAttendeeToEventAction::class)->execute($event->fresh(), 'user-003'))
        ->toThrow(\DomainException::class, 'User already registered for this event');
});

test('it rejects registration to a non published event', function () {
    $event = Event::query()->create([
        'title' => 'Draft Meetup '.uniqid(),
        'slug' => 'draft-'.uniqid(),
        'status' => 'draft',
        'max_attendees' => 5,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    expect(fn () => app(RegisterAttendeeToEventAction::class)->execute($event, 'user-004'))
        ->toThrow(\DomainException::class, 'Event is not open for registration');

    expect(EventUser::query()->where('event_id', $event->getKey())->count())->toBe(0);
});

test('it rejects registration to an event that already started', function () {
    $event = Event::query()->create([
        'title' => 'Past Meetup '.uniqid(),
        'slug' => 'past-'.uniqid(),
        'status' => 'published',
        'max_attendees' => 5,
        'attendees_count' => 0,
        'start_date' => now()->subDay(),
        'end_date' => now()->subDay()->addHours(3),
    ]);

    expect(fn () => app(RegisterAttendeeToEventAction::class)->execute($event, 'user-005'))
        ->toThrow(\DomainException::class, 'Event has already started');
});

test('it enforces capacity against the database even with a stale model', function () {
    $event = Event::query()->create([
        'title' => 'Stale Meetup '.uniqid(),
        'slug' => 'stale-'.uniqid(),
        'status' => 'published',
        'max_attendees' => 1,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    // Due richieste concorrenti caricano lo stesso evento prima che una delle due scriva.
    $staleCopy = Event::query()->findOrFail($event->getKey());

    app(RegisterAttendeeToEventAction::class)->execute($event, 'user-006');

    expect($staleCopy->attendees_count)->toBe(0)
        ->and(fn () => app(RegisterAttendeeToEventAction::class)->execute($staleCopy, 'user-007'))
        ->toThrow(\DomainException::class, 'Event is full');

    expect(EventUser::query()->where('event_id', $event->getKey())->count())->toBe(1);
});
