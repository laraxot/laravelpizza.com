# Chaos Monkey Event Rendering Playbook (Meetup Module)

## Scope

This playbook covers failures in events listing and event detail rendering across CMS blocks and Folio routes.

## Core Dependencies

- Model: `Modules\\Meetup\\Models\\Event`
- Data contract: `Event::toBlockArray()`
- Pages: `events` and `events.view` JSON pages
- Theme blocks: `pub_theme::components.blocks.events.list` and `.detail`

## Invariants

1. `toBlockArray()` must provide localized `url`.
2. Events list block must accept pre-hydrated `events` data.
3. Event detail block must be able to resolve event via `slug0` when `item` is not injected.
4. `events.view` fallback page must exist.

## Diagnostic Flow

1. Verify `events.json` block has valid `data.view` and `data.query` model.
2. Verify `ResolveBlockQueryAction` returns items for query.
3. Verify list template binds `:href=\"event.url\"`.
4. Verify `events_view.json` exists and references detail block view.
5. Verify detail block receives slug (`slug0`) from route data.

## Common Breakages and Fixes

## A) Empty Events Grid

- Cause: invalid `query.model` class or bad sort field.
- Fix: restore model class and safe ordering (`start_date`, `asc`).

## B) Event Links Without Locale

- Cause: URL concatenation done in Alpine.
- Fix: use model-provided `event.url` from `toBlockArray()`.

## C) Detail Page 404-like Behavior

- Cause: missing `events.view` page or mismatched slug flow.
- Fix: restore `events.view` JSON and verify Folio mapping to `container0.view`.

## D) Wrong Status/Date in Cards

- Cause: `toBlockArray()` changed date/status logic.
- Fix: restore `start_date`-based status and formatted date contract.

## Minimal Recovery Baseline

For emergency stabilization:
1. Keep only one events list block in `events.json`.
2. Use known-good query config.
3. Keep `events.view` with one detail block.
4. Reintroduce advanced fields after baseline passes.

## Suggested Regression Checks

1. One upcoming event appears on `/it/events`.
2. Clicking card opens localized detail URL.
3. Detail page renders title/date/location.
4. `/en/events` still links with `/en/...` prefix.
