<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\UpdateEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;

class UpdateEventActionTest extends TestCase
{
    private function fakeAuth(string|int|null $id): void
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

    #[Test]
    public function it_updates_event_attributes_and_persists_changes(): void
    {
        $this->fakeAuth(null);

        $event = Event::query()->create([
            'title' => 'before-update-'.uniqid(),
            'location' => 'Rome',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $updated = app(UpdateEventAction::class)->execute($event, [
            'title' => 'after-update-'.uniqid(),
            'location' => 'Bologna',
        ]);

        $this->assertSame('Bologna', $updated->location);
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'location' => 'Bologna',
        ], 'meetup');
    }

    #[Test]
    public function it_sets_updated_by_when_auth_id_exists(): void
    {
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

        $this->assertSame((string) $user->id, $updated->updated_by);
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'updated_by' => (string) $user->id,
        ], 'meetup');
    }

    #[Test]
    public function it_updates_dates_with_datetime_casts(): void
    {
        $this->fakeAuth(null);

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

        $this->assertSame($newStart->toDateTimeString(), $updated->start_date?->toDateTimeString());
        $this->assertSame($newEnd->toDateTimeString(), $updated->end_date?->toDateTimeString());
    }

    #[Test]
    public function it_preserves_untouched_attributes(): void
    {
        $this->fakeAuth(null);

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

        $this->assertSame('Original Location', $updated->location);
        $this->assertSame('published', $updated->status);
        $this->assertSame(50, $updated->attendees_count);
    }

    #[Test]
    public function it_does_not_set_updated_by_when_auth_id_is_null(): void
    {
        $this->fakeAuth(null);

        $event = Event::query()->create([
            'title' => 'null-update-'.uniqid(),
            'location' => 'Test',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $updated = app(UpdateEventAction::class)->execute($event, [
            'title' => 'null-updated-'.uniqid(),
        ]);

        // When auth_id is null, updated_by field is not set by the action
        $this->assertNull($updated->updated_by);
    }

    #[Test]
    public function it_updates_multiple_attributes_atomically(): void
    {
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

        $this->assertSame((string) $user->id, $updated->updated_by);
        $this->assertSame('New Location', $updated->location);
        $this->assertSame('New description', $updated->description);
        $this->assertSame('published', $updated->status);
    }

    #[Test]
    public function it_returns_updated_event_instance(): void
    {
        $this->fakeAuth(null);

        $event = Event::query()->create([
            'title' => 'instance-before-'.uniqid(),
            'location' => 'Naples',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $result = app(UpdateEventAction::class)->execute($event, [
            'title' => 'instance-after-'.uniqid(),
        ]);

        $this->assertInstanceOf(Event::class, $result);
        $this->assertNotNull($result->id);
    }
}
