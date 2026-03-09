Progress update on docs/code confidence for the event detail route:

- the incident has been narrowed down with a reproducible first fix:
  - removed the `Undefined variable $pageSlug` crash on `container0.view`
  - documented the exact failure and the corrected pattern in module/theme docs
- the Folio page now follows a simpler contract:
  - Volt binds `container0` and `slug0`
  - `<x-page>` receives only inline-derived slug/context
  - no redundant `mount()` state for trivial routing composition
- regression coverage now includes the localized detail route through Pest.

Current status:

- first blocker removed (`500` -> `200`);
- documentation aligned with the real runtime failure;
- second-stage debugging still open on why the event payload is not yet consistently visible in the rendered HTML for the automated fixture.
