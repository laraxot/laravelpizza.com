<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Actions\Event\CreateEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class, DatabaseTransactions::class);

function fakeAuth(string|int|null $id): void
{
    app()->instance('auth', new class($id)
    {
        public function __construct(private readonly string|int|null $id) {}

        public function id(): string|int|null
        {
            return $this->id;
        }
    });
}

test('it creates an event with provided attributes', function () {
    fakeAuth(null);

    $title = 'create-action-'.uniqid();
    $start = now()->addDay()->startOfMinute();
    $end = $start->copy()->addHours(2);

    $event = app(CreateEventAction::class)->execute([
        'title' => $title,
        'description' => 'Test description',
        'location' => 'Rome',
        'start_date' => $start,
        'end_date' => $end,
        'status' => 'published',
    ]);

    expect($event)->toBeInstanceOf(Event::class)
        ->and($event->title)->toBe($title)
        ->and($event->location)->toBe('Rome')
        ->and($event->start_date?->toDateTimeString())->toBe($start->toDateTimeString())
        ->and($event->end_date?->toDateTimeString())->toBe($end->toDateTimeString());

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'title' => $title,
        'location' => 'Rome',
    ], 'meetup');
});

test('it sets user_id and created_by from auth id', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $event = app(CreateEventAction::class)->execute([
        'title' => 'auth-create-'.uniqid(),
        'location' => 'Milan',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    expect($event->user_id)->toBe((int) $user->id)
        ->and($event->created_by)->toBe((string) $user->id);

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'user_id' => (int) $user->id,
        'created_by' => (string) $user->id,
    ], 'meetup');
});

test('it sets null user fields when auth id is null', function () {
    fakeAuth(null);

    $event = app(CreateEventAction::class)->execute([
        'title' => 'public-create-'.uniqid(),
        'location' => 'Naples',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    expect($event->user_id)->toBeNull()
        ->and($event->created_by)->toBeNull();
});

test('it generates slug from title when slug not provided', function () {
    fakeAuth(null);

    $title = 'Slug Title '.uniqid();
    $event = app(CreateEventAction::class)->execute([
        'title' => $title,
        'location' => 'Turin',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    expect($event->slug)->toBe(str($title)->slug()->toString());
});

test('it uses database transaction for atomicity', function () {
    fakeAuth(null);

    $initialCount = Event::count();

    $event = app(CreateEventAction::class)->execute([
        'title' => 'Transaction Test '.uniqid(),
        'location' => 'Genoa',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    expect(Event::count())->toBe($initialCount + 1);
    $this->assertDatabaseHas('events', ['id' => $event->id], 'meetup');
});

test('it fills all provided array attributes', function () {
    fakeAuth(null);

    $uniqueSuffix = uniqid();
    $data = [
        'title' => 'Full Data Event '.$uniqueSuffix,
        'description' => 'Complete test event',
        'location' => 'Palermo',
        'in_language' => 'en',
        'status' => 'draft',
        'attendees_count' => 25,
        'max_attendees' => 150,
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHours(3),
    ];

    $event = app(CreateEventAction::class)->execute($data);

    expect($event->title)->toBe('Full Data Event '.$uniqueSuffix)
        ->and($event->description)->toBe('Complete test event')
        ->and($event->in_language)->toBe('en')
        ->and($event->status)->toBe('draft')
        ->and($event->attendees_count)->toBe(25)
        ->and($event->max_attendees)->toBe(150);
});

test('it handles null fields gracefully', function () {
    fakeAuth(null);

    $event = app(CreateEventAction::class)->execute([
        'title' => 'Minimal Event '.uniqid(),
        'location' => 'Bari',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
        'description' => null,
    ]);

    expect($event->description)->toBeNull()
        ->and($event->title)->not->toBeNull()
        ->and($event->location)->not->toBeNull();
});
