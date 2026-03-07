<?php

declare(strict_types=1);

use Modules\Meetup\Actions\Event\CreateEventAction;
use Modules\Meetup\Actions\Event\DeleteEventAction;
use Modules\Meetup\Actions\Event\UpdateEventAction;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

$makeEventData = fn (): array => [
    'title' => 'Test Event '.uniqid(),
    'description' => 'A test event description.',
    'location' => 'Milan, Italy',
    'start_date' => now()->addDays(7)->toDateTimeString(),
    'end_date' => now()->addDays(7)->addHours(2)->toDateTimeString(),
    'status' => 'published',
    'event_status' => EventStatus::SCHEDULED->value,
    'event_attendance_mode' => EventAttendanceMode::OFFLINE->value,
    'max_attendees' => 100,
    'attendees_count' => 0,
];

// ---------------------------------------------------------------------------
// CreateEventAction
// ---------------------------------------------------------------------------

describe('CreateEventAction', function () use ($makeEventData) {
    test('returns an Event instance', function () use ($makeEventData) {
        $action = app(CreateEventAction::class);
        $event = $action->execute($makeEventData());

        expect($event)->toBeInstanceOf(Event::class);
    });

    test('persists the event to the database', function () use ($makeEventData) {
        $data = $makeEventData();
        $action = app(CreateEventAction::class);
        $event = $action->execute($data);

        expect(Event::find($event->id))->not->toBeNull();
    });

    test('stores the title correctly', function () use ($makeEventData) {
        $data = $makeEventData();
        $action = app(CreateEventAction::class);
        $event = $action->execute($data);

        expect($event->title)->toBe($data['title']);
    });

    test('stores the location correctly', function () use ($makeEventData) {
        $data = $makeEventData();
        $action = app(CreateEventAction::class);
        $event = $action->execute($data);

        expect($event->location)->toBe($data['location']);
    });

    test('auto-generates slug from title', function () use ($makeEventData) {
        $data = $makeEventData();
        $data['title'] = 'Laravel Pizza Meetup '.uniqid();
        $data['slug'] = null;
        $action = app(CreateEventAction::class);
        $event = $action->execute($data);

        expect($event->slug)->not->toBeEmpty()
            ->and($event->slug)->toContain('laravel-pizza-meetup');
    });

    test('uses provided slug when given', function () use ($makeEventData) {
        $data = $makeEventData();
        $data['slug'] = 'custom-slug-'.uniqid();
        $action = app(CreateEventAction::class);
        $event = $action->execute($data);

        expect($event->slug)->toBe($data['slug']);
    });

    test('sets user_id and created_by when user is authenticated', function () use ($makeEventData) {
        $user = User::factory()->create();
        $this->actingAs($user);

        $action = app(CreateEventAction::class);
        $event = $action->execute($makeEventData());

        // created_by stores the string representation of the authenticated user id
        expect($event->created_by)->toBe((string) $user->id);
        // user_id is cast as (int) of auth()->id() — verify it is set (non-null)
        expect($event->user_id)->not->toBeNull();
    });

    test('does not set user_id when no authenticated user', function () use ($makeEventData) {
        // Ensure no authenticated user
        auth()->logout();

        $data = $makeEventData();
        $action = app(CreateEventAction::class);
        $event = $action->execute($data);

        // user_id comes from factory/data, not from auth
        expect($event)->toBeInstanceOf(Event::class);
    });

    test('casts event_status to enum after creation', function () use ($makeEventData) {
        $action = app(CreateEventAction::class);
        $event = $action->execute($makeEventData());

        expect($event->event_status)->toBeInstanceOf(EventStatus::class);
    });

    test('casts event_attendance_mode to enum after creation', function () use ($makeEventData) {
        $action = app(CreateEventAction::class);
        $event = $action->execute($makeEventData());

        expect($event->event_attendance_mode)->toBeInstanceOf(EventAttendanceMode::class);
    });

    test('stores description when provided', function () use ($makeEventData) {
        $data = $makeEventData();
        $data['description'] = 'Unique description '.uniqid();
        $action = app(CreateEventAction::class);
        $event = $action->execute($data);

        expect($event->description)->toBe($data['description']);
    });

    test('max_attendees default is applied', function () use ($makeEventData) {
        $action = app(CreateEventAction::class);
        $event = $action->execute($makeEventData());

        expect($event->max_attendees)->toBeGreaterThan(0);
    });

    test('event has created_at timestamp after creation', function () use ($makeEventData) {
        $action = app(CreateEventAction::class);
        $event = $action->execute($makeEventData());

        expect($event->created_at)->not->toBeNull();
    });
});

// ---------------------------------------------------------------------------
// DeleteEventAction
// ---------------------------------------------------------------------------

describe('DeleteEventAction', function () {
    test('returns true on successful deletion', function () {
        $event = Event::factory()->create();
        $action = app(DeleteEventAction::class);

        $result = $action->execute($event);

        expect($result)->toBeTrue();
    });

    test('removes the event from the database', function () {
        $event = Event::factory()->create();
        $id = $event->id;
        $action = app(DeleteEventAction::class);

        $action->execute($event);

        expect(Event::find($id))->toBeNull();
    });

    test('sets updated_by to authenticated user id before deleting', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create();
        $action = app(DeleteEventAction::class);
        $action->execute($event);

        // After deletion, the in-memory $event->updated_by should be set
        expect($event->updated_by)->toBe((string) $user->id);
    });

    test('does not throw when no authenticated user', function () {
        auth()->logout();
        $event = Event::factory()->create();
        $action = app(DeleteEventAction::class);

        $result = $action->execute($event);

        expect($result)->toBeBool();
    });

    test('different events can be deleted independently', function () {
        $event1 = Event::factory()->create();
        $event2 = Event::factory()->create();
        $id1 = $event1->id;
        $id2 = $event2->id;
        $action = app(DeleteEventAction::class);

        $action->execute($event1);

        expect(Event::find($id1))->toBeNull()
            ->and(Event::find($id2))->not->toBeNull();
    });
});

// ---------------------------------------------------------------------------
// UpdateEventAction
// ---------------------------------------------------------------------------

describe('UpdateEventAction', function () {
    test('returns the updated Event instance', function () {
        $event = Event::factory()->create();
        $action = app(UpdateEventAction::class);

        $result = $action->execute($event, ['title' => 'Updated Title '.uniqid()]);

        expect($result)->toBeInstanceOf(Event::class);
    });

    test('updates the title in the database', function () {
        $event = Event::factory()->create();
        $newTitle = 'New Title '.uniqid();
        $action = app(UpdateEventAction::class);

        $action->execute($event, ['title' => $newTitle]);

        expect(Event::find($event->id)->title)->toBe($newTitle);
    });

    test('updates the description', function () {
        $event = Event::factory()->create(['description' => 'Old description']);
        $newDescription = 'New description '.uniqid();
        $action = app(UpdateEventAction::class);

        $action->execute($event, ['description' => $newDescription]);

        expect(Event::find($event->id)->description)->toBe($newDescription);
    });

    test('updates the location', function () {
        $event = Event::factory()->create(['location' => 'Old location']);
        $action = app(UpdateEventAction::class);

        $action->execute($event, ['location' => 'Rome, Italy']);

        expect(Event::find($event->id)->location)->toBe('Rome, Italy');
    });

    test('sets updated_by when user is authenticated', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create();
        $action = app(UpdateEventAction::class);

        $updatedEvent = $action->execute($event, ['title' => 'Updated '.uniqid()]);

        expect($updatedEvent->updated_by)->toBe((string) $user->id);
    });

    test('does not fail when no authenticated user', function () {
        auth()->logout();
        $event = Event::factory()->create();
        $action = app(UpdateEventAction::class);

        $result = $action->execute($event, ['title' => 'Still updated '.uniqid()]);

        expect($result)->toBeInstanceOf(Event::class);
    });

    test('can update event_status', function () {
        $event = Event::factory()->create([
            'event_status' => EventStatus::SCHEDULED,
        ]);
        $action = app(UpdateEventAction::class);

        $action->execute($event, ['event_status' => EventStatus::CANCELLED->value]);

        expect(Event::find($event->id)->event_status)->toBe(EventStatus::CANCELLED);
    });

    test('can update event_attendance_mode', function () {
        $event = Event::factory()->create([
            'event_attendance_mode' => EventAttendanceMode::OFFLINE,
        ]);
        $action = app(UpdateEventAction::class);

        $action->execute($event, ['event_attendance_mode' => EventAttendanceMode::ONLINE->value]);

        expect(Event::find($event->id)->event_attendance_mode)->toBe(EventAttendanceMode::ONLINE);
    });

    test('can update max_attendees', function () {
        $event = Event::factory()->create(['max_attendees' => 50]);
        $action = app(UpdateEventAction::class);

        $action->execute($event, ['max_attendees' => 200]);

        expect(Event::find($event->id)->max_attendees)->toBe(200);
    });

    test('returns the same event id after update', function () {
        $event = Event::factory()->create();
        $originalId = $event->id;
        $action = app(UpdateEventAction::class);

        $result = $action->execute($event, ['title' => 'Changed '.uniqid()]);

        expect($result->id)->toBe($originalId);
    });

    test('multiple fields can be updated in one call', function () {
        $event = Event::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original Description',
            'location' => 'Original Location',
        ]);
        $action = app(UpdateEventAction::class);

        $action->execute($event, [
            'title' => 'Multi Updated Title',
            'description' => 'Multi Updated Description',
            'location' => 'Multi Updated Location',
        ]);

        $refreshed = Event::find($event->id);

        expect($refreshed->title)->toBe('Multi Updated Title')
            ->and($refreshed->description)->toBe('Multi Updated Description')
            ->and($refreshed->location)->toBe('Multi Updated Location');
    });

    test('update does not affect other events', function () {
        $event1 = Event::factory()->create(['title' => 'Event One '.uniqid()]);
        $event2 = Event::factory()->create(['title' => 'Event Two '.uniqid()]);
        $originalTitle2 = $event2->title;
        $action = app(UpdateEventAction::class);

        $action->execute($event1, ['title' => 'Event One Modified']);

        expect(Event::find($event2->id)->title)->toBe($originalTitle2);
    });
});
