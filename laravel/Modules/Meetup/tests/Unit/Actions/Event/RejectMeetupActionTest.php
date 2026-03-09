<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use DomainException;
use Modules\Meetup\Actions\Event\RejectMeetupAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('it rejects pending event and sets rejected status', function () {
    $event = Event::query()->create([
        'title' => 'Da rifiutare '.uniqid(),
        'slug' => 'da-rifiutare-'.uniqid(),
        'status' => 'pending',
        'max_attendees' => 50,
        'attendees_count' => 0,
    ]);

    $rejected = app(RejectMeetupAction::class)->execute($event, 'admin-1', 'Luogo non disponibile');

    expect($rejected->status)->toBe('rejected')
        ->and($rejected->updated_by)->toBe('admin-1')
        ->and($rejected->meta_data['rejection_reason'])->toBe('Luogo non disponibile');
});

test('it rejects without reason', function () {
    $event = Event::query()->create([
        'title' => 'Rifiuto silenzioso '.uniqid(),
        'slug' => 'rifiuto-'.uniqid(),
        'status' => 'pending',
        'max_attendees' => 20,
        'attendees_count' => 0,
    ]);

    $rejected = app(RejectMeetupAction::class)->execute($event, 'admin-2');

    expect($rejected->status)->toBe('rejected');
});

test('it throws when rejecting a non-pending event', function () {
    $event = Event::query()->create([
        'title' => 'Gia pubblicato '.uniqid(),
        'slug' => 'pub-reject-'.uniqid(),
        'status' => 'published',
        'max_attendees' => 50,
        'attendees_count' => 0,
    ]);

    expect(fn () => app(RejectMeetupAction::class)->execute($event, 'admin-1'))
        ->toThrow(DomainException::class, 'Only pending events can be rejected.');
});

test('rejected event is not visible via published scope', function () {
    $event = Event::query()->create([
        'title' => 'Scope rejected '.uniqid(),
        'slug' => 'scope-rej-'.uniqid(),
        'status' => 'pending',
        'max_attendees' => 20,
        'attendees_count' => 0,
    ]);

    app(RejectMeetupAction::class)->execute($event, 'admin-1', 'Non idoneo');

    $found = Event::query()
        ->where('id', $event->id)
        ->where('status', 'published')
        ->first();

    expect($found)->toBeNull();
});
