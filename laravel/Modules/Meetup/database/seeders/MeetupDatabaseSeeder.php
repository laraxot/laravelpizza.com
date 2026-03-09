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
        if ($this->command !== null) {
            $this->command->info('Seeding Meetup module data...');
        }

        // 1. Create venues across Italian cities
        $venues = Venue::factory(5)->create();
        if ($this->command !== null) {
            $this->command->info('Venues created: '.$venues->count());
        }

        // 2. Create performers (speakers, hosts, moderators)
        $performers = Performer::factory(10)->create();
        if ($this->command !== null) {
            $this->command->info('Performers created: '.$performers->count());
        }

        // 3. Create sponsors across tiers (gold + silver/bronze)
        $sponsors = Sponsor::factory(3)->create();
        if ($this->command !== null) {
            $this->command->info('Sponsors created: '.$sponsors->count());
        }

        // 4. Create upcoming events and attach to venues
        $upcomingEvents = collect();
        $venuesToUse = $venues->take(3);
        \Webmozart\Assert\Assert::isInstanceOf($venuesToUse, \Illuminate\Support\Collection::class);
        foreach ($venuesToUse as $venue) {
            \Webmozart\Assert\Assert::isInstanceOf($venue, Venue::class);
            $eventFactory = Event::factory();
            \Webmozart\Assert\Assert::isInstanceOf($eventFactory, \Modules\Meetup\Database\Factories\EventFactory::class);
            $event = $eventFactory->upcoming()->withVenue($venue)->create();
            $upcomingEvents->push($event);
        }

        // Ensure at least one nearly-full upcoming event for REGS-03 testing
        $firstVenue = $venues->first();
        \Webmozart\Assert\Assert::isInstanceOf($firstVenue, Venue::class);
        $eventFactory = Event::factory();
        \Webmozart\Assert\Assert::isInstanceOf($eventFactory, \Modules\Meetup\Database\Factories\EventFactory::class);
        $nearlyFullEvent = $eventFactory->upcoming()->nearlyFull()->withVenue($firstVenue)->create();
        $upcomingEvents->push($nearlyFullEvent);

        // Ensure at least one fully-booked upcoming event for REGS-03 testing
        $lastVenue = $venues->last();
        \Webmozart\Assert\Assert::isInstanceOf($lastVenue, Venue::class);
        $eventFactory = Event::factory();
        \Webmozart\Assert\Assert::isInstanceOf($eventFactory, \Modules\Meetup\Database\Factories\EventFactory::class);
        $fullyBookedEvent = $eventFactory->upcoming()->fullyBooked()->withVenue($lastVenue)->create();
        $upcomingEvents->push($fullyBookedEvent);

        if ($this->command !== null) {
            $this->command->info('Upcoming events created: '.$upcomingEvents->count());
        }

        // 5. Create past events
        $pastEvents = collect();
        $venuesToUseForPast = $venues->take(2);
        \Webmozart\Assert\Assert::isInstanceOf($venuesToUseForPast, \Illuminate\Support\Collection::class);
        foreach ($venuesToUseForPast as $venue) {
            \Webmozart\Assert\Assert::isInstanceOf($venue, Venue::class);
            $eventFactory = Event::factory();
            \Webmozart\Assert\Assert::isInstanceOf($eventFactory, \Modules\Meetup\Database\Factories\EventFactory::class);
            $event = $eventFactory->past()->withVenue($venue)->create();
            $pastEvents->push($event);
        }

        if ($this->command !== null) {
            $this->command->info('Past events created: '.$pastEvents->count());
        }

        $allEvents = $upcomingEvents->concat($pastEvents);

        // 6. Attach performers to events via pivot
        foreach ($allEvents as $event) {
            \Webmozart\Assert\Assert::isInstanceOf($event, Event::class);
            $assignedPerformers = $performers->random(rand(1, 3));
            \Webmozart\Assert\Assert::isIterable($assignedPerformers);
            foreach ($assignedPerformers as $performer) {
                \Webmozart\Assert\Assert::isInstanceOf($performer, Performer::class);
                $event->performers()->attach($performer->id, [
                    'role' => fake()->randomElement(['speaker', 'host', 'moderator']),
                    'order' => fake()->numberBetween(1, 10),
                ]);
            }
        }

        // 7. Attach sponsors to events via pivot
        foreach ($allEvents as $event) {
            \Webmozart\Assert\Assert::isInstanceOf($event, Event::class);
            $assignedSponsors = $sponsors->random(rand(1, 2));
            \Webmozart\Assert\Assert::isIterable($assignedSponsors);
            foreach ($assignedSponsors as $sponsor) {
                \Webmozart\Assert\Assert::isInstanceOf($sponsor, Sponsor::class);
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
