## Goal
Make pages rich-snippets ready at page level using `schema.org/WebPage` and `schema.org/ProfilePage` where appropriate, not only entity-level schemas (e.g. Event).

## Scope
- Define canonical page-type mapping by route/page context.
- Emit page-level JSON-LD centrally (DRY) via metatags/layout layer.
- Ensure profile pages include `ProfilePage` structure and a `Person` `mainEntity` when semantically valid.
- Keep auth/edit/account pages honest (avoid misleading page types).

## Baseline findings
- Event detail currently emits entity schema (`Event`) in block view.
- Global metatags currently do not emit a canonical page-type JSON-LD.
- In User module, active profile page is `/profile/edit` (authenticated edit flow), no clear public profile route yet.

## Deliverables
- Route-to-page-type policy doc (WebPage, CollectionPage, ItemPage, ProfilePage, AboutPage, ContactPage).
- Implementation in shared metatags/page layer.
- Pest tests for page schema output by context.
- Follow-up tickets for public profile route if required for full `ProfilePage` semantics.

## Definition of done
- Every public page emits page-level JSON-LD with coherent `@type`.
- Profile contexts emit `ProfilePage` only when semantically correct.
- No conflicting schema types between page-level and entity-level JSON-LD.
