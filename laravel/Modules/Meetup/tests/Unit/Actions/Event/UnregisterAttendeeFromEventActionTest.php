<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\RegisterAttendeeToEventAction;
use Modules\Meetup\Actions\Event\UnregisterAttendeeFromEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it unregisters attendee and decrements counter', function () {
    $event = Event::query()->create([
        'title' => 'Meetup '.uniqid(),
        'slug' => 'meetup-'.uniqid(),
        'max_attendees' => 10,
        'attendees_count' => 1,
        'start_date' => now()->addDays(30),
    ]);

    EventUser::query()->create([
        'event_id' => $event->getKey(),
        'user_id' => 'user-001',
    ]);

    $result = app(UnregisterAttendeeFromEventAction::class)->execute($event, 'user-001');

    expect($result)->toBeTrue();
    $event->refresh();
    expect($event->attendees_count)->toBe(0);
    expect(EventUser::query()->where('user_id', 'user-001')->exists())->toBeFalse();
});

test('it throws when user is not registered', function () {
    $event = Event::query()->create([
        'title' => 'Meetup '.uniqid(),
        'slug' => 'meetup-'.uniqid(),
        'max_attendees' => 10,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
    ]);

    expect(fn () => app(UnregisterAttendeeFromEventAction::class)->execute($event, 'user-not-registered'))
        ->toThrow(\DomainException::class, 'User is not registered for this event');
});

test('it preserves minimum attendees count at zero', function () {
    $event = Event::query()->create([
        'title' => 'Meetup '.uniqid(),
        'slug' => 'meetup-'.uniqid(),
        'max_attendees' => 10,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
    ]);

    EventUser::query()->create([
        'event_id' => $event->getKey(),
        'user_id' => 'user-001',
    ]);

    app(UnregisterAttendeeFromEventAction::class)->execute($event, 'user-001');

    $event->refresh();
    expect($event->attendees_count)->toBe(0);
});
