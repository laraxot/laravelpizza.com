# Phase 1: Foundation & Models - Context

**Gathered:** 2026-03-05
**Status:** Ready for planning
**Source:** PRD Express Path (docs/PRD.md)

<domain>
## Phase Boundary

Establish the core data structure for the Meetup module, including Eloquent models, migrations, factories, and seeders for Events, Venues, Performers, and Sponsors.

</domain>

<decisions>
## Implementation Decisions

### Data Models
- **Event**: id, slug, title, description, start_at, end_at, venue_id, published_at.
- **Venue**: id, name, address, city, geo_comune_id.
- **Performer**: id, name, bio, role.
- **Sponsor**: id, name, logo, url.
- **Pivot Tables**: EventUser (registrations), EventPerformer (speakers/organizers), EventSponsor (sponsorships).
- **Relationships**: Use `$this->belongsToManyX()` for many-to-many, never `$this->belongsToMany()`.

### Database & Migrations
- One table, one create migration.
- Use `XotBaseMigration` with `tableCreate()` and `tableUpdate()` methods.
- No per-module database connections in `config/database.php`.

### Code Quality
- Every PHP file: `declare(strict_types=1);` at the top.
- PHPStan level 10 compatibility (strict types, no property_exists).
- Use `casts()` method instead of `protected $casts` for Laravel 11+.

### Registration Logic (REGS-03)
- Models must support capacity tracking to prevent over-registration.

### Claude's Discretion
- Specific column types (e.g., string vs text) for descriptions.
- Detailed seeder data content.
- Naming of pivot tables (standard Laraxot naming expected).

</decisions>

<specifics>
## Specific Ideas

- The project uses the "Laraxot" modular architecture.
- Follow established patterns for BaseModels and XotBaseMigrations.

</specifics>

<deferred>
## Deferred Ideas

- Paid ticketing flows (Phase 2).
- Real-time ticket counter (Phase 10).
- Social networking features.

</deferred>

---

*Phase: 01-foundation*
*Context gathered: 2026-03-05 via PRD Express Path*
