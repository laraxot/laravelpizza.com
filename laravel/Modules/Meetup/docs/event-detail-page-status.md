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

## Impact

- detail pages can render the CMS block again
- `events/detail.blade.php` receives the slug context needed to resolve the `Event`
- the page no longer needs a custom `mount()` for trivial state composition

## Key files

- `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`
- `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`
- `Modules/Cms/resources/views/components/page.blade.php`
- `Modules/Meetup/app/Models/Event.php`
