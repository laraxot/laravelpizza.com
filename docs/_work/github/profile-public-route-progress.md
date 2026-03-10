Progress update on public profile route `/{$locale}/profile/{id}`.

Completed:
- aligned the public profile runtime route to render the dedicated profile block instead of drifting across stale duplicate Folio templates;
- fixed missing theme translation keys for `pub_theme::profile.*` in `it`, `en`, `de`, `es`, `fr`, `ru`;
- made the profile page visibly render localized labels like `Profilo pubblico`, `Scopri gli eventi`, `Dettagli profilo`;
- hardened `Modules\\Cms\\Support\\PageSchemaBuilder` so public profile pages emit `ProfilePage` with `mainEntity` `Person` without PHPStan property-access regressions;
- updated docs in `Modules/Cms/docs/profile-public-route-resolution.md` and `Themes/Meetup/docs/public-profile-route.md`.

Verification:
- HTTP content check via Laravel kernel confirms the real page now contains `Profilo pubblico`, `Scopri gli eventi`, `Dettagli profilo`, and the public user name;
- `./vendor/bin/pest Modules/Cms/tests/Feature/Frontoffice/FolioRoutes/PublicProfileRouteTest.php Modules/Cms/tests/Unit/Support/PageSchemaBuilderTest.php`
  - result: `7 passed (30 assertions)`;
- `./vendor/bin/phpstan analyse Modules/Cms/app/Support/PageSchemaBuilder.php --no-progress --debug`
  - result: `No errors`.

Quality-gate status:
- `phpmd`: not installed in this workspace (`phpmd-not-installed`);
- `phpinsights` still reports structural complexity/style debt on `PageSchemaBuilder`; functional correctness is fixed, but the class still needs decomposition to satisfy the stricter insights threshold;
- full `./vendor/bin/phpstan analyse Modules --debug` is running separately because the whole-module scan is very large; this update covers the profile/CMS slice already fixed and verified.
