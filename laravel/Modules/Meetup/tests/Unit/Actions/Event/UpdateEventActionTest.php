<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\UpdateEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

function fakeUpdateAuth(string|int|null $id): void
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

test('it updates event attributes and persists changes', function () {
    fakeUpdateAuth(null);

    $event = Event::query()->create([
        'title' => 'before-update-'.uniqid(),
        'location' => 'Rome',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $newTitle = 'after-update-'.uniqid();
    $updated = app(UpdateEventAction::class)->execute($event, [
        'title' => $newTitle,
        'location' => 'Bologna',
    ]);

    expect($updated->location)->toBe('Bologna')
        ->and($updated->title)->toBe($newTitle);

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'location' => 'Bologna',
        'title' => $newTitle,
    ], 'meetup');
});

test('it sets updated_by when auth id exists', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $event = Event::query()->create([
        'title' => 'updated-by-'.uniqid(),
        'location' => 'Florence',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $updated = app(UpdateEventAction::class)->execute($event, [
        'title' => 'updated-by-final-'.uniqid(),
    ]);

    expect($updated->updated_by)->toBe((string) $user->id);
    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'updated_by' => (string) $user->id,
    ], 'meetup');
});

test('it updates dates with datetime casts', function () {
    fakeUpdateAuth(null);

    $event = Event::query()->create([
        'title' => 'dates-before-'.uniqid(),
        'location' => 'Verona',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $newStart = now()->addDays(7)->startOfMinute();
    $newEnd = $newStart->copy()->addHours(3);

    $updated = app(UpdateEventAction::class)->execute($event, [
        'start_date' => $newStart,
        'end_date' => $newEnd,
    ]);

    expect($updated->start_date?->toDateTimeString())->toBe($newStart->toDateTimeString())
        ->and($updated->end_date?->toDateTimeString())->toBe($newEnd->toDateTimeString());
});

test('it preserves untouched attributes', function () {
    fakeUpdateAuth(null);

    $event = Event::query()->create([
        'title' => 'preserve-original-'.uniqid(),
        'location' => 'Original Location',
        'status' => 'published',
        'attendees_count' => 50,
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $updated = app(UpdateEventAction::class)->execute($event, [
        'title' => 'preserve-updated-'.uniqid(),
    ]);

    expect($updated->location)->toBe('Original Location')
        ->and($updated->status)->toBe('published')
        ->and($updated->attendees_count)->toBe(50);
});

test('it does not set updated_by when auth id is null', function () {
    fakeUpdateAuth(null);

    $event = Event::query()->create([
        'title' => 'null-update-'.uniqid(),
        'location' => 'Test',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $updated = app(UpdateEventAction::class)->execute($event, [
        'title' => 'null-updated-'.uniqid(),
    ]);

    expect($updated->updated_by)->toBeNull();
});

test('it updates multiple attributes atomically', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $event = Event::query()->create([
        'title' => 'multi-before-'.uniqid(),
        'location' => 'Old Location',
        'description' => 'Old description',
        'status' => 'draft',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $newStart = now()->addDays(5);
    $newEnd = $newStart->copy()->addHours(2);

    $updated = app(UpdateEventAction::class)->execute($event, [
        'title' => 'multi-after-'.uniqid(),
        'location' => 'New Location',
        'description' => 'New description',
        'status' => 'published',
        'start_date' => $newStart,
        'end_date' => $newEnd,
    ]);

    expect($updated->updated_by)->toBe((string) $user->id)
        ->and($updated->location)->toBe('New Location')
        ->and($updated->description)->toBe('New description')
        ->and($updated->status)->toBe('published');
});

test('it returns updated event instance', function () {
    fakeUpdateAuth(null);

    $event = Event::query()->create([
        'title' => 'instance-before-'.uniqid(),
        'location' => 'Naples',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $result = app(UpdateEventAction::class)->execute($event, [
        'title' => 'instance-after-'.uniqid(),
    ]);

    expect($result)->toBeInstanceOf(Event::class)
        ->and($result->id)->not->toBeNull();
});
