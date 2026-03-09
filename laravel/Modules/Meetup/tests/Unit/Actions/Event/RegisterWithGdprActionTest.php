<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\RegisterWithGdprAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test('it registers user with valid gdpr consents', function () {
    $user = User::factory()->create();
    $event = Event::query()->create([
        'title' => 'Pizzata '.uniqid(),
        'slug' => 'pizzata-'.uniqid(),
        'max_attendees' => 10,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    $registration = app(RegisterWithGdprAction::class)->execute(
        $event,
        $user,
        ['privacy_accepted' => true, 'terms_accepted' => true]
    );

    expect($registration)->toBeInstanceOf(EventUser::class);
    $event->refresh();
    expect($event->attendees_count)->toBe(1);
    expect(EventUser::query()->where('event_id', $event->getKey())->where('user_id', $user->id)->exists())->toBeTrue();
});

test('it throws when privacy_accepted is missing', function () {
    $user = User::factory()->create();
    $event = Event::query()->create([
        'title' => 'Pizzata '.uniqid(),
        'slug' => 'pizzata-'.uniqid(),
        'max_attendees' => 10,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    expect(fn () => app(RegisterWithGdprAction::class)->execute(
        $event,
        $user,
        ['privacy_accepted' => false, 'terms_accepted' => true]
    ))->toThrow(\DomainException::class, 'Privacy policy and terms of service must be accepted');
});

test('it throws when terms_accepted is missing', function () {
    $user = User::factory()->create();
    $event = Event::query()->create([
        'title' => 'Pizzata '.uniqid(),
        'slug' => 'pizzata-'.uniqid(),
        'max_attendees' => 10,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    expect(fn () => app(RegisterWithGdprAction::class)->execute(
        $event,
        $user,
        ['privacy_accepted' => true, 'terms_accepted' => false]
    ))->toThrow(\DomainException::class, 'Privacy policy and terms of service must be accepted');
});

test('it propagates full event exception when event is full', function () {
    $user = User::factory()->create();
    $event = Event::query()->create([
        'title' => 'Full Pizzata '.uniqid(),
        'slug' => 'full-'.uniqid(),
        'max_attendees' => 0,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    expect(fn () => app(RegisterWithGdprAction::class)->execute(
        $event,
        $user,
        ['privacy_accepted' => true, 'terms_accepted' => true]
    ))->toThrow(\DomainException::class, 'Event is full');
});
