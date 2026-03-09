# Event Detail Page - Current State

## Status

Updated on 2026-03-09.

## Active route pattern

- locale aware detail URLs: `/it/events/{slug}`, `/en/events/{slug}`
- Folio entrypoint: `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`
- CMS page rendered: `events.view`
- final detail block: `pub_theme::components.blocks.events.detail`

## 2026-03-09 incident

### User-visible symptom

Clicking an event from `/it/events` did not open the detail page correctly.

### Real failure

The request crashed before normal event fallback logic completed:

- error: `Undefined variable $pageSlug`
- route: `container0.view`

### Root cause

The Folio page introduced redundant derived state (`pageSlug` and `data`) and depended on `mount()` for values that can be computed directly from the route parameters already bound by Volt.

This broke the rendering scope and made the detail page more fragile than necessary.

## Current implementation

The detail page now follows the simpler pattern:

- Volt binds `container0` and `slug0`
- the CMS slug is derived inline as `"$this->container0.'.view'"`
- route context is passed to `<x-page>` via `data`

That keeps:

- `container0`
- `slug0`

as the only source of truth.

## Presenter rules for the detail block

For `pub_theme::components.blocks.events.detail`:

- no model query in the standard `/events/{slug}` path;
- no fake RSVP or client-only success states when no real registration backend exists;
- organizer, owner, attendance mode, location and optional metadata must be rendered only from data already present on the resolved `Event`;
- empty states must be explicit and localized.

## Impact

- detail pages can render the CMS block again
- `events/detail.blade.php` receives the slug context needed to resolve the `Event`
- the page no longer needs a custom `mount()` for trivial state composition

## Key files

- `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`
- `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`
- `Modules/Cms/resources/views/components/page.blade.php`
- `Modules/Meetup/app/Models/Event.php`

## Verification evidence (2026-03-09)

- Runtime URL check completed on `http://127.0.0.1:8000/it/events/ut-quae-facere-placeat-labore-expedita-TwKN`
- HTTP status: `200 OK`
- Detail page renders event content (no fallback text `Nessun evento trovato`)
- No runtime errors for `$pageSlug` or `Property [$event]`
- Pest test: `Modules/Meetup/tests/Feature/EventDetailPageTest.php` passes
- phpinsights on test file: passing (`98.8%` style score)

## UX improvement target for real event pages

The real page `/it/events/id-id-quidem-quae-eveniet-Jy1p` should help the user answer:

1. what the event is;
2. when it happens;
3. where or how to attend;
4. who organizes it;
5. how to join, or why joining is not currently available.

## Quality gate notes

- `phpmd` is not available in current vendor bin (`./vendor/bin/phpmd` missing)
- `phpstan` on full `Modules/Meetup` reports pre-existing module-wide issues not introduced by this detail-page fix
