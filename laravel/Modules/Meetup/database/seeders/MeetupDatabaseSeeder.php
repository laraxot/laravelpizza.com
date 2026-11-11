<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Modules\Meetup\Database\Factories\EventFactory;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Models\Sponsor;
use Modules\Meetup\Models\Venue;
use Webmozart\Assert\Assert;

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
        if ($this->command !== null) {
            $this->command->info('Seeding Meetup module data...');
        }

        // 1. Create venues across Italian cities
        $venueFactory = Venue::factory(5);
        Assert::isInstanceOf($venueFactory, Factory::class);
        $venues = $venueFactory->create();
        Assert::isInstanceOf($venues, Collection::class);
        if ($this->command !== null) {
            $this->command->info('Venues created: '.$venues->count());
        }

        // 2. Create performers (speakers, hosts, moderators)
        $performerFactory = Performer::factory(10);
        Assert::isInstanceOf($performerFactory, Factory::class);
        $performers = $performerFactory->create();
        Assert::isInstanceOf($performers, Collection::class);
        if ($this->command !== null) {
            $this->command->info('Performers created: '.$performers->count());
        }

        // 3. Create sponsors across tiers (gold + silver/bronze)
        $sponsorFactory = Sponsor::factory(3);
        Assert::isInstanceOf($sponsorFactory, Factory::class);
        $sponsors = $sponsorFactory->create();
        Assert::isInstanceOf($sponsors, Collection::class);
        if ($this->command !== null) {
            $this->command->info('Sponsors created: '.$sponsors->count());
        }

        // 4. Create upcoming events and attach to venues
        $upcomingEvents = collect();
        $venuesToUse = $venues->take(3);
        Assert::isInstanceOf($venuesToUse, Collection::class);
        foreach ($venuesToUse as $venue) {
            Assert::isInstanceOf($venue, Venue::class);
            $eventFactory = Event::factory();
            Assert::isInstanceOf($eventFactory, EventFactory::class);
            $event = $eventFactory->upcoming()->withVenue($venue)->create();
            $upcomingEvents->push($event);
        }

        // Ensure at least one nearly-full upcoming event for REGS-03 testing
        $firstVenue = $venues->first();
        Assert::isInstanceOf($firstVenue, Venue::class);
        $eventFactory = Event::factory();
        Assert::isInstanceOf($eventFactory, EventFactory::class);
        $nearlyFullEvent = $eventFactory->upcoming()->nearlyFull()->withVenue($firstVenue)->create();
        $upcomingEvents->push($nearlyFullEvent);

        // Ensure at least one fully-booked upcoming event for REGS-03 testing
        $lastVenue = $venues->last();
        Assert::isInstanceOf($lastVenue, Venue::class);
        $eventFactory = Event::factory();
        Assert::isInstanceOf($eventFactory, EventFactory::class);
        $fullyBookedEvent = $eventFactory->upcoming()->fullyBooked()->withVenue($lastVenue)->create();
        $upcomingEvents->push($fullyBookedEvent);

        if ($this->command !== null) {
            $this->command->info('Upcoming events created: '.$upcomingEvents->count());
        }

        // 5. Create past events
        $pastEvents = collect();
        $venuesToUseForPast = $venues->take(2);
        Assert::isInstanceOf($venuesToUseForPast, Collection::class);
        foreach ($venuesToUseForPast as $venue) {
            Assert::isInstanceOf($venue, Venue::class);
            $eventFactory = Event::factory();
            Assert::isInstanceOf($eventFactory, EventFactory::class);
            $event = $eventFactory->past()->withVenue($venue)->create();
            $pastEvents->push($event);
        }

        if ($this->command !== null) {
            $this->command->info('Past events created: '.$pastEvents->count());
        }

        $allEvents = $upcomingEvents->concat($pastEvents);

        // 6. Attach performers to events via pivot
        foreach ($allEvents as $event) {
            Assert::isInstanceOf($event, Event::class);
            $assignedPerformers = $performers->random(rand(1, 3));
            Assert::isIterable($assignedPerformers);
            foreach ($assignedPerformers as $performer) {
                Assert::isInstanceOf($performer, Performer::class);
                $event->performers()->attach($performer->id, [
                    'role' => fake()->randomElement(['speaker', 'host', 'moderator']),
                    'order' => fake()->numberBetween(1, 10),
                ]);
            }
        }

        // 7. Attach sponsors to events via pivot
        foreach ($allEvents as $event) {
            Assert::isInstanceOf($event, Event::class);
            $assignedSponsors = $sponsors->random(rand(1, 2));
            Assert::isIterable($assignedSponsors);
            foreach ($assignedSponsors as $sponsor) {
                Assert::isInstanceOf($sponsor, Sponsor::class);
                $event->sponsors()->attach($sponsor->id);
            }
        }

        if ($this->command !== null) {
            $this->command->info('Meetup seeding complete.');
            $this->command->table(
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
}
