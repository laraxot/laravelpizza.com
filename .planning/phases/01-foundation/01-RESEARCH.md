# Phase 1: Foundation & Models - Research

**Objective:** Research how to implement core data structures for the Meetup module following Laraxot patterns.

## Findings

### Laraxot Patterns
- **Migrations:** Must use `XotBaseMigration`. This base class provides `tableCreate` and `tableUpdate` methods, ensuring migrations are idempotent and safe to run multiple times. It requires a corresponding Model to be present to determine the table name and connection.
- **Models:** Must extend `Modules\Xot\Models\XotBaseModel` (usually via a module-level `BaseModel`).
- **Pivot Tables:** Must extend `Modules\Xot\Models\XotBasePivot`.
- **Naming:** Follow standard Laravel plural naming for tables and singular StudlyCase for models.

### Current State
- `Event` model exists and is robust, but missing foreign keys for `Venue`.
- `Venue`, `Performer`, and `Sponsor` models are completely missing.
- `EventPerformer` and `EventSponsor` pivot models exist but use incorrect column names (e.g., `user_id` instead of `performer_id`).
- Migrations are fragmented (multiple files for `events` and `profiles`), violating the "one table, one create migration" rule.

### Domain Schema (Meetup)
- **venues**: id, name, slug, address, city, geo_comune_id, lat, lng, capacity.
- **performers**: id, name, slug, bio, avatar, role (speaker, organizer).
- **sponsors**: id, name, slug, logo, url, level (platinum, gold, silver).
- **event_performer**: event_id, performer_id.
- **event_sponsor**: event_id, sponsor_id.

### Registration Capacity (REGS-03)
- The `events` table already has `max_attendees` and `attendees_count`.
- Logic for preventing over-registration should be implemented in a Spatie Action (Phase 2), but the model must provide the necessary fields and relations.

## Rationale
- Using `XotBaseMigration` ensures that migrations don't fail if a table or column already exists, which is critical for the modular "Super Mucca" workflow.
- Consolidating migrations now prevents schema drift and makes the codebase easier to maintain.

## Recommendations
1. **Consolidate Migrations:** Merge fragmented migrations into single "create" files for `events`, `profiles`, `venues`, `performers`, and `sponsors`.
2. **Create Missing Models:** Implement `Venue`, `Performer`, and `Sponsor` models extending `Meetup\Models\BaseModel`.
3. **Update Event Model:** Add `venue_id` and corresponding relationship. Add `performers()` and `sponsors()` many-to-many relationships.
4. **Fix Pivot Models:** Update `EventPerformer` and `EventSponsor` to use correct foreign keys.

## Validation Architecture
- **Unit Tests:** Verify that models can be instantiated and relationships return correct results.
- **Schema Tests:** Run `php artisan migrate` and verify table structures in the database.
- **Factory Tests:** Ensure all models have working factories that generate valid data.

---
*Researched: 2026-03-05*
*Confidence: HIGH*
