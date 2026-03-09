Progress update:

## Docs-first step completed
- Added: `laravel/Themes/Meetup/docs/headernav-auth-cta-localization-uiux.md`

## Implemented
Updated both headernav blades:
- `laravel/Modules/Cms/resources/views/components/headernav/simple.blade.php`
- `laravel/Modules/Cms/resources/views/components/blocks/headernav/simple.blade.php`

Changes:
1. Replaced legacy auth keys:
   - removed `user::auth.login-in`
   - removed `user::auth.sign-up`
2. Enforced theme-localized keys:
   - `pub_theme::navigation.auth.login`
   - `pub_theme::navigation.auth.register`
3. Enforced localized auth URLs:
   - `LaravelLocalization::localizeUrl('/auth/login')`
   - `LaravelLocalization::localizeUrl('/auth/register')`
4. Improved guest CTA UI hierarchy:
   - Login = secondary outline button
   - Register = primary filled red button
   - explicit `focus-visible` ring styles for accessibility

## Pest regression test added
- `laravel/Modules/Cms/tests/Unit/Views/HeadernavAuthCtaLocalizationTest.php`

Assertions verify:
- theme keys are present
- legacy user auth keys are absent
- localized auth URLs are present

## Quality gates executed
- Pest: ✅ `2 passed (16 assertions)`
- PHPStan (module-level fallback due config not analyzing single test path): ⚠️ pre-existing severe syntax errors in `Modules/Cms/database/factories/PostFactory.php` and `Modules/Cms/database/seeders/CmsMassSeeder.php` (unrelated to this patch)
- PHPInsights: ✅ run completed on test file
- PHPMD: ⚠️ `./vendor/bin/phpmd` not available in this workspace

## UX references used
- WCAG 2.4.7 Focus Visible: https://www.w3.org/WAI/WCAG22/Understanding/focus-visible
- web.dev focus styling guidance: https://web.dev/articles/style-focus
- Button hierarchy guidance: https://designsystem.gov.scot/components/button
