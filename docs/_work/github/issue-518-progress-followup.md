Progress update on issue #518:

- identified and fixed a real crash in `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`: the route was failing with `Undefined variable $pageSlug`;
- simplified the Folio/Volt page to use only route-bound `container0` and `slug0`, removing redundant derived state (`pageSlug`, `data`, `mount()`);
- cleared Laravel caches and added a regression test for the localized route:
  - `Modules/Meetup/tests/Feature/EventDetailPageTest.php`
- updated technical docs in:
  - `Themes/Meetup/docs/troubleshooting/undefined-pageslug-container0-view.md`
  - `Modules/Meetup/docs/event-detail-page-status.md`

Current verified state:

- `/it/events/{slug}` no longer fails with HTTP 500 for the `$pageSlug` error;
- internal Laravel request now returns `200`;
- the route still has a second rendering issue to finish: the page responds successfully, but the event content is not yet consistently surfaced in the final HTML for the regression test fixture.

Quality gate status for this progress slice:

- `pint` clean on touched files;
- `phpcs` on the new Pest file is clean except for the repo-level warning `PHP version not specified`;
- `phpstan analyze Modules/Meetup --level=10 --debug` still reports pre-existing module errors unrelated to this page fix;
- `phpmd` binary is not present in `vendor/bin`;
- `phpinsights` is currently blocked in this environment by its `composer.lock` lookup/security step.
