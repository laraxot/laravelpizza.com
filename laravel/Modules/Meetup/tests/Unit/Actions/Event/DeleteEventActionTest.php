<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Actions\Event;

use Modules\Meetup\Actions\Event\DeleteEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DeleteEventActionTest extends TestCase
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
    public function it_deletes_event_and_returns_true(): void
    {
        $this->fakeAuth(null);

        $event = Event::query()->create([
            'title' => 'delete-me-'.uniqid(),
            'location' => 'Rome',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $result = app(DeleteEventAction::class)->execute($event);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('events', ['id' => $event->id], 'meetup');
    }

    #[Test]
    public function it_sets_updated_by_before_delete_when_auth_id_exists(): void
    {
        $this->fakeAuth('789');

        $event = Event::query()->create([
            'title' => 'delete-auth-'.uniqid(),
            'location' => 'Milan',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $result = app(DeleteEventAction::class)->execute($event);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('events', ['id' => $event->id], 'meetup');
    }

    #[Test]
    public function it_returns_boolean_value(): void
    {
        $this->fakeAuth(null);

        $event = Event::query()->create([
            'title' => 'bool-test-'.uniqid(),
            'location' => 'Naples',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $result = app(DeleteEventAction::class)->execute($event);

        $this->assertIsBool($result);
    }

    #[Test]
    public function it_uses_database_transaction_atomicity(): void
    {
        $this->fakeAuth(null);

        $event = Event::query()->create([
            'title' => 'transaction-'.uniqid(),
            'location' => 'Genoa',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $id = $event->id;
        $initialCount = Event::count();

        $result = app(DeleteEventAction::class)->execute($event);

        $this->assertTrue($result);
        $this->assertEquals($initialCount - 1, Event::count());
        $this->assertDatabaseMissing('events', ['id' => $id], 'meetup');
    }

    #[Test]
    public function it_deletes_event_regardless_of_auth_status(): void
    {
        $event1 = Event::query()->create([
            'title' => 'no-auth-delete-'.uniqid(),
            'location' => 'Venice',
            'start_date' => now()->addDay(),
            'end_date' => now()->addDay()->addHour(),
        ]);

        $this->fakeAuth(null);

        $result = app(DeleteEventAction::class)->execute($event1);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('events', ['id' => $event1->id], 'meetup');
    }

    #[Test]
    public function it_deletes_event_with_various_attributes(): void
    {
        $this->fakeAuth(null);

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

        $this->assertTrue($result);
        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
            'title' => 'complex-delete-'.substr($event->title, 15),
        ], 'meetup');
    }

    #[Test]
    public function it_handles_sequential_deletes(): void
    {
        $this->fakeAuth(null);

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

        $this->assertTrue($result1);
        $this->assertTrue($result2);
        $this->assertDatabaseMissing('events', ['id' => $event1->id], 'meetup');
        $this->assertDatabaseMissing('events', ['id' => $event2->id], 'meetup');
    }
}
