Progress update on the localized event-detail incident:

- confirmed the first hard failure was not the model lookup but the Folio page itself:
  - `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php`
  - runtime error: `Undefined variable $pageSlug`
- removed redundant Volt state and rewired the page to derive the CMS slug inline from route params;
- after the fix, `/it/events/{slug}` returns `200` instead of crashing with `500`;
- added regression coverage with `Modules/Meetup/tests/Feature/EventDetailPageTest.php`;
- refreshed the module/theme docs to document the failure mode and the DRY+KISS fix.

Current status:

- crash fixed;
- route is alive again;
- there is still a second rendering/data-flow issue to close before declaring the event detail fully recovered, because the response is `200` but the event payload is not yet consistently rendered for the test fixture.
