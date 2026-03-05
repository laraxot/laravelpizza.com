---
phase: 01-foundation
plan: 02
subsystem: database
tags: [factories, seeders, laravel-eloquent, meetup, venue, performer, sponsor, event]

requires:
  - phase: 01-foundation/01-01
    provides: "Core Meetup models (Event, Venue, Performer, Sponsor) and migrations"
  - phase: 01-foundation/01-04
    provides: "Meetup migration foundation with canonical columns"

provides:
  - "VenueFactory with Italian city data and capacity states (large/small)"
  - "PerformerFactory with realistic speaker/host/moderator data"
  - "SponsorFactory with tier states (gold, platinum, community) and correct column names"
  - "EventFactory with venue_id support, past/upcoming/nearlyFull/fullyBooked states"
  - "MeetupDatabaseSeeder populating all entities with relational pivot attachments"
  - "Event model performers() and sponsors() BelongsToMany relationships"
  - "Event model venue() BelongsTo relationship"

affects:
  - "02-core-actions: Actions can now use factories for unit testing"
  - "REGS-03: nearlyFull/fullyBooked event states enable capacity registration testing"

tech-stack:
  added: []
  patterns:
    - "Laravel Eloquent factory states for test scenario variants (past, upcoming, nearlyFull, fullyBooked)"
    - "Seeder with ordered insertion ensuring referential integrity"
    - "BelongsToManyX for pivot relationships following Laraxot architecture"

key-files:
  created:
    - "laravel/Modules/Meetup/database/factories/VenueFactory.php"
    - "laravel/Modules/Meetup/database/factories/SponsorFactory.php"
    - "laravel/Modules/Meetup/database/seeders/MeetupDatabaseSeeder.php"
  modified:
    - "laravel/Modules/Meetup/database/factories/EventFactory.php"
    - "laravel/Modules/Meetup/app/Models/Event.php"
    - "laravel/Modules/Meetup/app/Models/Sponsor.php"
    - "laravel/Modules/Meetup/composer.json"

key-decisions:
  - "Seeder is additive (no truncate) to preserve existing data across multiple seed runs"
  - "Sponsor model fillable corrected to use contact_email/contact_name matching canonical migration columns"
  - "EventFactory slug uses Str::random(4) suffix to prevent unique constraint violations in repeated test runs"
  - "Seeder uses testing env (--env=testing) to avoid pivot table schema differences in legacy production DB"

requirements-completed:
  - REGS-03
---

# Phase 1 Plan 02: Factories and seeders summary

**Model factories for Venue, Performer, Sponsor, and Event with REGS-03 capacity test states, plus MeetupDatabaseSeeder creating reproducible relational datasets**

## Performance

- **Duration:** 57 min
- **Started:** 2026-03-05T13:35:41Z
- **Completed:** 2026-03-05T14:32:00Z
- **Tasks:** 2
- **Files modified:** 7

## Accomplishments

- Created VenueFactory with 10 Italian cities, latitude/longitude in Italian geographic range, and small/large capacity states
- Created SponsorFactory with gold/platinum/community tier states matching database schema
- Updated EventFactory with venue_id support via withVenue() state, corrected past() date logic, added upcoming/nearlyFull/fullyBooked states for REGS-03
- Created MeetupDatabaseSeeder with ordered seeding (venues, performers, sponsors, events, pivot relationships)
- Fixed Sponsor model fillable and SponsorFactory to use correct column names from canonical migration
- Added performers(), sponsors(), venue() relationships to Event model

## Task commits

Each task was committed atomically:

1. **Task 1: Create factories for all core models** - `b7f726912` (feat)
2. **Task 2: Implement MeetupDatabaseSeeder** - `d51a61895` (feat)

## Files created/modified

- `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/database/factories/VenueFactory.php` - New factory with Italian cities and capacity states
- `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/database/factories/SponsorFactory.php` - New factory with tier states using correct DB column names
- `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/database/factories/EventFactory.php` - Updated with withVenue(), nearlyFull(), fullyBooked(), upstream slug fix
- `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/database/seeders/MeetupDatabaseSeeder.php` - New seeder with full relational data
- `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/app/Models/Event.php` - Added performers(), sponsors(), venue() relationships
- `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/app/Models/Sponsor.php` - Fixed fillable columns to match migration schema
- `/var/www/_bases/base_laravelpizza/laravel/Modules/Meetup/composer.json` - Added seeders namespace to autoload

## Decisions made

- Seeder is additive (no truncate) to allow multiple seed runs without destroying test data
- Sponsor model needed correction from email/contact_person to contact_email/contact_name (schema mismatch with migration)
- EventFactory slug now includes Str::random(4) suffix to avoid unique constraint violations across repeated test runs
- belongsToManyX used for Event.performers() and Event.sponsors() per Laraxot architecture rules
- Seeder verified with --env=testing; production DB has legacy pivot schema with char(36) id without default

## Deviations from plan

### Auto-fixed issues

**1. [Rule 1 - Bug] Fixed Sponsor model fillable mismatch with DB schema**
- **Found during:** Task 2 (MeetupDatabaseSeeder)
- **Issue:** Sponsor model fillable used `email` and `contact_person` but the canonical migration uses `contact_email` and `contact_name`. Seeder failed with "Unknown column 'email'"
- **Fix:** Updated Sponsor.php fillable to match migration columns; updated SponsorFactory definition accordingly
- **Files modified:** `laravel/Modules/Meetup/app/Models/Sponsor.php`, `laravel/Modules/Meetup/database/factories/SponsorFactory.php`
- **Verification:** Seeder ran successfully creating 3 sponsors without SQL errors
- **Committed in:** `d51a61895`

**2. [Rule 2 - Missing Critical] Added performers(), sponsors(), venue() to Event model**
- **Found during:** Task 2 (MeetupDatabaseSeeder)
- **Issue:** Seeder needed to attach performers and sponsors to events via pivot tables, but Event had no relationship methods defined
- **Fix:** Added performers() with belongsToManyX(Performer, 'event_performer'), sponsors() with belongsToManyX(Sponsor, 'event_sponsor'), and venue() with belongsTo(Venue, 'location_id')
- **Files modified:** `laravel/Modules/Meetup/app/Models/Event.php`
- **Verification:** Seeder successfully attached performers and sponsors to all events
- **Committed in:** `73700db18`

**3. [Rule 3 - Blocking] Added seeders namespace to Meetup composer.json autoload**
- **Found during:** Task 2 (MeetupDatabaseSeeder)
- **Issue:** Seeder class not found because `Modules\\Meetup\\Database\\Seeders\\` namespace was not registered in autoload
- **Fix:** Added `"Modules\\Meetup\\Database\\Seeders\\": "database/seeders/"` to composer.json autoload.psr-4; ran `composer update laraxot/module_meetup`
- **Files modified:** `laravel/Modules/Meetup/composer.json`
- **Verification:** `php -r "class_exists('Modules\\Meetup\\Database\\Seeders\\MeetupDatabaseSeeder')"` returned EXISTS
- **Committed in:** `73700db18`

---

**Total deviations:** 3 auto-fixed (1 bug, 1 missing critical, 1 blocking)
**Impact on plan:** All auto-fixes required for correctness and seeder operation. No scope creep.

## Issues encountered

- Parallel agent activity created multiple "." commits capturing some of our changes alongside unrelated files. All our changes are in the repository.
- Production DB `event_performer` pivot table has `char(36)` UUID primary key without default value, causing `attach()` to fail outside testing env. This is a pre-existing schema inconsistency in production.
- The `--env=testing` flag must be used when invoking the seeder to target the canonical test DB schema.

## User setup required

None - no external service configuration required.

## Next phase readiness

- All factories and seeder are ready for use in Phase 2 (Core Actions) unit tests
- REGS-03 capacity test states (nearlyFull, fullyBooked) available via EventFactory
- Event model now has complete relationship graph: performers, sponsors, venue, owner, organizer

## Self-Check: PASSED

All files verified present:
- VenueFactory.php: FOUND
- SponsorFactory.php: FOUND
- EventFactory.php: FOUND
- MeetupDatabaseSeeder.php: FOUND

All commits verified in history:
- b7f726912: FOUND (factories)
- d51a61895: FOUND (seeder + model relationships)
- 73700db18: FOUND (composer autoload + event model)

---
*Phase: 01-foundation*
*Completed: 2026-03-05*
