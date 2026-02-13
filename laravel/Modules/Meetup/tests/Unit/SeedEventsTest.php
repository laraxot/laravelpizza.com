<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit;

use Modules\Meetup\Actions\Event\SeedEventsFromJsonAction;
use Modules\Meetup\Models\Event;
use Tests\TestCase;

class SeedEventsTest extends TestCase
{
    /**
     * Test that events can be seeded from JSON correctly.
     */
    public function test_events_are_seeded_correctly_from_json(): void
    {
        // 1. Arrange: Clear existing events
        Event::truncate();

        // 2. Act: Run the seeding action
        app(SeedEventsFromJsonAction::class)->execute();

        // 3. Assert: Verify counts
        $this->assertEquals(6, Event::count());

        // 4. Assert: Verify specific record data
        $event = Event::where('title', 'Laravel 11 Release Pizza Party')->first();
        $this->assertNotNull($event);
        $this->assertEquals('Tech Hub Downtown, 123 Main St', $event->location);
        $this->assertEquals(30, $event->max_attendees);
        $this->assertEquals('2025-12-15 18:00:00', $event->start_date->format('Y-m-d H:i:s'));

        // 5. Assert: Verify Schema.org output
        $schema = $event->toSchemaOrg();
        $this->assertEquals('https://schema.org', $schema['@context']);
        $this->assertEquals('Event', $schema['@type']);
        $this->assertEquals('Laravel 11 Release Pizza Party', $schema['name']);
        $this->assertStringContainsString('2025-12-15T18:00:00', $schema['startDate']);
    }
}
