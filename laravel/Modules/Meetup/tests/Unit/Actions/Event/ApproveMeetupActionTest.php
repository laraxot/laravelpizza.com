<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use DomainException;
use Modules\Meetup\Actions\Event\ApproveMeetupAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it approves pending event and sets published status', function () {
    $event = Event::query()->create([
        'title' => 'Da approvare '.uniqid(),
        'slug' => 'da-approvare-'.uniqid(),
        'status' => 'pending',
        'max_attendees' => 50,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    $approved = app(ApproveMeetupAction::class)->execute($event, 'admin-1');

    expect($approved->status)->toBe('published');
});

test('it throws when trying to approve a non-pending event', function () {
    $event = Event::query()->create([
        'title' => 'Gia pubblicato '.uniqid(),
        'slug' => 'published-'.uniqid(),
        'status' => 'published',
        'max_attendees' => 50,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    expect(fn () => app(ApproveMeetupAction::class)->execute($event, 'admin-1'))
        ->toThrow(DomainException::class, 'Only pending events can be approved.');
});

test('it throws when trying to approve a draft event', function () {
    $event = Event::query()->create([
        'title' => 'Bozza '.uniqid(),
        'slug' => 'draft-'.uniqid(),
        'status' => 'draft',
        'max_attendees' => 50,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    expect(fn () => app(ApproveMeetupAction::class)->execute($event, 'admin-1'))
        ->toThrow(DomainException::class, 'Only pending events can be approved.');
});

test('approved event is visible via published scope', function () {
    $event = Event::query()->create([
        'title' => 'Scope test '.uniqid(),
        'slug' => 'scope-'.uniqid(),
        'status' => 'pending',
        'max_attendees' => 50,
        'attendees_count' => 0,
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(30)->addHours(3),
    ]);

    app(ApproveMeetupAction::class)->execute($event, 'admin-1');

    $found = Event::query()
        ->where('id', $event->id)
        ->where('status', 'published')
        ->first();

    expect($found)->not->toBeNull();
});
