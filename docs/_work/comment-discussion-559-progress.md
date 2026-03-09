Progress implemented for headernav auth CTA localization/UI:

- Guest header auth labels now use theme navigation translation keys only:
  - `pub_theme::navigation.auth.login`
  - `pub_theme::navigation.auth.register`
- Removed legacy keys that could produce language inconsistencies:
  - `user::auth.login-in`
  - `user::auth.sign-up`
- URLs now explicitly localized via `LaravelLocalization::localizeUrl('/auth/login')` and `/auth/register`.
- CTA hierarchy improved:
  - login as secondary outline
  - register as primary filled
  - added focus-visible ring classes for keyboard accessibility.

Regression protection added with Pest test:
- `Modules/Cms/tests/Unit/Views/HeadernavAuthCtaLocalizationTest.php`
- Result: `2 passed (16 assertions)`.

Tracking issue: #557
