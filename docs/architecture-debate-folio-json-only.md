# architecture debate: folio public pages json only

## context

the meetup theme uses folio + volt for frontoffice. laraxot governance explicitly forbids controllers for frontoffice and forbids page-per-blade implementations for dynamic public pages.

the critical rule is already stated here:

- [folio pages json only rule](./folio-pages-json-only-rule.md)

this document explains *why* the rule is the winning architecture.

## the furious internal debate

### position a (strict governance): public pages are json only

- **claim**: every public page must be defined exclusively via json content under `config/local/laravelpizza/database/content/pages/{slug}.json`.
- **reason**:
  - content is data, not code.
  - folio catch-all pages + x-page already provide the rendering pipeline.
  - avoids routing/controller sprawl.

### position b (exceptions): allow blade pages for special cases

- **claim**: allow dedicated blade pages for certain slugs when a page is “special”.
- **reason**:
  - perceived faster iteration.
  - direct control over markup.

## winner: position a (json only)

### why it wins

- **dry**: one rendering pipeline instead of many bespoke pages.
- **kiss**: one place to look for page definitions (json), not scattered blades.
- **governance**: enforces no-controller and prevents accidental routing divergence.
- **theme stability**: the theme provides blocks/components; pages should compose blocks, not introduce new page templates.
- **translation consistency**: json content blocks and theme components keep localization patterns uniform.

## practical rule (the actionable policy)

- never create `Themes/Meetup/resources/views/pages/{slug}.blade.php` for dynamic public pages.
- create/modify only json page files and compose `content_blocks` using existing theme components.
- if a new layout is truly needed, implement it as a reusable block/component (not a one-off page).

## consequences

- predictable frontoffice architecture.
- fewer regressions from route/controller/page duplication.
- easier audits and future refactors.
