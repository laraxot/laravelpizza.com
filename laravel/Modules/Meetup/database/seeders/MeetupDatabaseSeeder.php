<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Models\Sponsor;
use Modules\Meetup\Models\Venue;

/**
 * Populates the Meetup module with representative development/test data.
 *
 * Seed order ensures referential integrity:
 * 1. Venues  -> no foreign dependencies
 * 2. Performers -> no foreign dependencies
 * 3. Sponsors -> no foreign dependencies
 * 4. Events (upcoming) -> reference venue via location_id
 * 5. Events (past) -> reference venue via location_id
 * 6. Attach performers and sponsors to events via pivot tables
 *
 * Provides at least one upcoming and one past event, satisfying
 * REGS-03 verification scenarios (capacity-aware registration).
 */
class MeetupDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('Seeding Meetup module data...');

        // 1. Create venues across Italian cities
        /** @var \Illuminate\Database\Eloquent\Collection<int, Venue> $venues */
        $venues = Venue::factory(5)->create();
        $this->command?->info('Venues created: '.$venues->count());

        // 2. Create performers (speakers, hosts, moderators)
        /** @var \Illuminate\Database\Eloquent\Collection<int, Performer> $performers */
        $performers = Performer::factory(10)->create();
        $this->command?->info('Performers created: '.$performers->count());

        // 3. Create sponsors across tiers (gold + silver/bronze)
        /** @var \Illuminate\Database\Eloquent\Collection<int, Sponsor> $sponsors */
        $sponsors = Sponsor::factory(3)->create();
        $this->command?->info('Sponsors created: '.$sponsors->count());

        // 4. Create upcoming events and attach to venues
        $upcomingEvents = collect();
        foreach ($venues->take(3) as $venue) {
            $event = Event::factory()->upcoming()->withVenue($venue)->create();
            $upcomingEvents->push($event);
        }

        // Ensure at least one nearly-full upcoming event for REGS-03 testing
        $nearlyFullEvent = Event::factory()->upcoming()->nearlyFull()->withVenue($venues->first())->create();
        $upcomingEvents->push($nearlyFullEvent);

        // Ensure at least one fully-booked upcoming event for REGS-03 testing
        $fullyBookedEvent = Event::factory()->upcoming()->fullyBooked()->withVenue($venues->last())->create();
        $upcomingEvents->push($fullyBookedEvent);

        $this->command?->info('Upcoming events created: '.$upcomingEvents->count());

        // 5. Create past events
        $pastEvents = collect();
        foreach ($venues->take(2) as $venue) {
            $event = Event::factory()->past()->withVenue($venue)->create();
            $pastEvents->push($event);
        }

        $this->command?->info('Past events created: '.$pastEvents->count());

        $allEvents = $upcomingEvents->concat($pastEvents);

        // 6. Attach performers to events via pivot
        foreach ($allEvents as $event) {
            $assignedPerformers = $performers->random(rand(1, 3));
            foreach ($assignedPerformers as $performer) {
                $event->performers()->attach($performer->id, [
                    'role' => fake()->randomElement(['speaker', 'host', 'moderator']),
                    'order' => fake()->numberBetween(1, 10),
                ]);
            }
        }

        // 7. Attach sponsors to events via pivot
        foreach ($allEvents as $event) {
            $assignedSponsors = $sponsors->random(rand(1, 2));
            foreach ($assignedSponsors as $sponsor) {
                $event->sponsors()->attach($sponsor->id);
            }
        }

        $this->command?->info('Meetup seeding complete.');
        $this->command?->table(
            ['Entity', 'Count'],
            [
                ['Venues', Venue::count()],
                ['Performers', Performer::count()],
                ['Sponsors', Sponsor::count()],
                ['Events (total)', Event::count()],
                ['Events (upcoming)', Event::upcoming()->count()],
                ['Events (past)', Event::past()->count()],
            ]
        );
    }
}
