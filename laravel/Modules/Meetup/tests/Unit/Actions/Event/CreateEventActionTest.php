<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\CreateEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;

class CreateEventActionTest extends TestCase
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
    public function it_creates_an_event_with_provided_attributes(): void
    {
        $this->fakeAuth(null);

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

        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame($title, $event->title);
        $this->assertSame('Rome', $event->location);
        $this->assertSame($start->toDateTimeString(), $event->start_date?->toDateTimeString());
        $this->assertSame($end->toDateTimeString(), $event->end_date?->toDateTimeString());
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => $title,
            'location' => 'Rome',
        ], 'meetup');
    }

    #[Test]
    public function it_sets_user_id_and_created_by_from_auth_id(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = app(CreateEventAction::class)->execute([
            'title' => 'auth-create-'.uniqid(),
            'location' => 'Milan',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $this->assertSame((int) $user->id, $event->user_id);
        $this->assertSame((string) $user->id, $event->created_by);
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'user_id' => (int) $user->id,
            'created_by' => (string) $user->id,
        ], 'meetup');
    }

    #[Test]
    public function it_sets_null_user_fields_when_auth_id_is_null(): void
    {
        $this->fakeAuth(null);

        $event = app(CreateEventAction::class)->execute([
            'title' => 'public-create-'.uniqid(),
            'location' => 'Naples',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $this->assertNull($event->user_id);
        $this->assertNull($event->created_by);
    }

    #[Test]
    public function it_generates_slug_from_title_when_slug_not_provided(): void
    {
        $this->fakeAuth(null);

        $title = 'Slug Title '.uniqid();
        $event = app(CreateEventAction::class)->execute([
            'title' => $title,
            'location' => 'Turin',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $this->assertSame(str($title)->slug()->toString(), $event->slug);
    }

    #[Test]
    public function it_uses_database_transaction_for_atomicity(): void
    {
        $this->fakeAuth(null);

        $initialCount = Event::count();

        $event = app(CreateEventAction::class)->execute([
            'title' => 'Transaction Test '.uniqid(),
            'location' => 'Genoa',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $this->assertEquals($initialCount + 1, Event::count());
        $this->assertDatabaseHas('events', ['id' => $event->id], 'meetup');
    }

    #[Test]
    public function it_fills_all_provided_array_attributes(): void
    {
        $this->fakeAuth(null);

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

        $this->assertSame('Full Data Event '.$uniqueSuffix, $event->title);
        $this->assertSame('Complete test event', $event->description);
        $this->assertSame('en', $event->in_language);
        $this->assertSame('draft', $event->status);
        $this->assertSame(25, $event->attendees_count);
        $this->assertSame(150, $event->max_attendees);
    }

    #[Test]
    public function it_handles_null_fields_gracefully(): void
    {
        $this->fakeAuth(null);

        $event = app(CreateEventAction::class)->execute([
            'title' => 'Minimal Event '.uniqid(),
            'location' => 'Bari',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
            'description' => null,
        ]);

        $this->assertNull($event->description);
        $this->assertNotNull($event->title);
        $this->assertNotNull($event->location);
    }
}
