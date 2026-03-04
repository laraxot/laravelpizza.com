<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit;

use Modules\Meetup\Actions\Event\SeedEventsFromJsonAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

it('seeds events correctly from json', function (): void {
    // 1. Arrange: Clear existing events
    Event::truncate();

    // 2. Act: Run the seeding action
    app(SeedEventsFromJsonAction::class)->execute();

    // 3. Assert: Verify counts
    expect(Event::count())->toBe(6);

    // 4. Assert: Verify specific record data
    /** @var Event $event */
    $event = Event::where('title', 'Laravel 11 Release Pizza Party')->first();
    expect($event)->not->toBeNull();
    expect($event->location)->toBe('Tech Hub Downtown, 123 Main St');
    expect($event->max_attendees)->toBe(30);
    expect($event->start_date->format('Y-m-d H:i:s'))->toBe('2025-12-15 18:00:00');

    // 5. Assert: Verify Schema.org output
    $schema = $event->toSchemaOrg();
    expect($schema['@context'])->toBe('https://schema.org');
    expect($schema['@type'])->toBe('Event');
    expect($schema['name'])->toBe('Laravel 11 Release Pizza Party');
    expect($schema['startDate'])->toContain('2025-12-15T18:00:00');
});
