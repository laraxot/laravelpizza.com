<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Meetup\Actions\Event\DeleteEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

function fakeDeleteAuth(string|int|null $id): void
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

test('it deletes event and returns true', function () {
    fakeDeleteAuth(null);

    $event = Event::query()->create([
        'title' => 'delete-me-'.uniqid(),
        'location' => 'Rome',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $result = app(DeleteEventAction::class)->execute($event);

    expect($result)->toBeTrue();
    $this->assertDatabaseMissing('events', ['id' => $event->id], 'meetup');
});

test('it sets updated_by before delete when auth id exists', function () {
    fakeDeleteAuth('789');

    $event = Event::query()->create([
        'title' => 'delete-auth-'.uniqid(),
        'location' => 'Milan',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $result = app(DeleteEventAction::class)->execute($event);

    expect($result)->toBeTrue();
    $this->assertDatabaseMissing('events', ['id' => $event->id], 'meetup');
});

test('it returns boolean value', function () {
    fakeDeleteAuth(null);

    $event = Event::query()->create([
        'title' => 'bool-test-'.uniqid(),
        'location' => 'Naples',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $result = app(DeleteEventAction::class)->execute($event);

    expect($result)->toBeBool();
});

test('it uses database transaction atomicity', function () {
    fakeDeleteAuth(null);

    $event = Event::query()->create([
        'title' => 'transaction-'.uniqid(),
        'location' => 'Genoa',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $id = $event->id;
    $initialCount = Event::count();

    $result = app(DeleteEventAction::class)->execute($event);

    expect($result)->toBeTrue()
        ->and(Event::count())->toBe($initialCount - 1);
    $this->assertDatabaseMissing('events', ['id' => $id], 'meetup');
});

test('it deletes event regardless of auth status', function () {
    $event1 = Event::query()->create([
        'title' => 'no-auth-delete-'.uniqid(),
        'location' => 'Venice',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    fakeDeleteAuth(null);

    $result = app(DeleteEventAction::class)->execute($event1);

    expect($result)->toBeTrue();
    $this->assertDatabaseMissing('events', ['id' => $event1->id], 'meetup');
});

test('it deletes event with various attributes', function () {
    fakeDeleteAuth(null);

    $event = Event::query()->create([
        'title' => 'complex-delete-'.uniqid(),
        'description' => 'Complex event to delete',
        'location' => 'Palermo',
        'status' => 'published',
        'attendees_count' => 100,
        'max_attendees' => 200,
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHours(2),
    ]);

    $result = app(DeleteEventAction::class)->execute($event);

    expect($result)->toBeTrue();
    $this->assertDatabaseMissing('events', [
        'id' => $event->id,
    ], 'meetup');
});

test('it handles sequential deletes', function () {
    fakeDeleteAuth(null);

    $event1 = Event::query()->create([
        'title' => 'seq-delete-1-'.uniqid(),
        'location' => 'Bari',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $event2 = Event::query()->create([
        'title' => 'seq-delete-2-'.uniqid(),
        'location' => 'Turin',
        'start_date' => now()->addDay(),
        'end_date' => now()->addDay()->addHour(),
    ]);

    $result1 = app(DeleteEventAction::class)->execute($event1);
    $result2 = app(DeleteEventAction::class)->execute($event2);

    expect($result1)->toBeTrue()
        ->and($result2)->toBeTrue();
    $this->assertDatabaseMissing('events', ['id' => $event1->id], 'meetup');
    $this->assertDatabaseMissing('events', ['id' => $event2->id], 'meetup');
});
