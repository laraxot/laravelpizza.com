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
    ]);

    app(RegisterAttendeeToEventAction::class)->execute($event, 'user-003');

    expect(fn () => app(RegisterAttendeeToEventAction::class)->execute($event->fresh(), 'user-003'))
        ->toThrow(\DomainException::class, 'User already registered for this event');
});
