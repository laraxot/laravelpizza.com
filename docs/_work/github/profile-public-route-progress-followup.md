Follow-up after running `./vendor/bin/phpstan analyse Modules --debug` from `laravel/`.

Global gate status:
- the first full run completed with `EXIT_CODE=1` and surfaced **25 severe syntax errors** that were stopping deeper analysis;
- those blockers were concentrated in 6 files:
  - `Modules/Tenant/database/factories/DatabaseConfigFactory.php`
  - `Modules/UI/database/factories/AssetFactory.php`
  - `Modules/UI/database/factories/ThemeFactory.php`
  - `Modules/User/database/factories/MembershipFactory.php`
  - `Modules/User/database/factories/PermissionRoleFactory.php`
  - `Modules/User/database/migrations/2026_01_01_000000_create_profiles_table.php`

Implemented:
- fixed broken factory syntax (`$faker` misuse, missing commas, malformed `state(fn ...)` closures);
- fixed the malformed anonymous migration declaration in `create_profiles_table`;
- verified all 6 files with `php -l`;
- verified `PageSchemaBuilder.php` with PHPStan and the profile route with Pest after the profile-page fixes.

Verification evidence:
- `php -l` passes on all 6 formerly broken files;
- `./vendor/bin/phpstan analyse Modules/Cms/app/Support/PageSchemaBuilder.php --no-progress --debug`
  - result: `No errors`;
- `./vendor/bin/pest Modules/Cms/tests/Feature/Frontoffice/FolioRoutes/PublicProfileRouteTest.php Modules/Cms/tests/Unit/Support/PageSchemaBuilderTest.php`
  - result: `7 passed (30 assertions)`.

Current remaining blocker after the syntax cleanup:
- targeted PHPStan on the 6-file set no longer reports parse errors, but still reports semantic issues on `Modules/Tenant/database/factories/DatabaseConfigFactory.php` because `Modules\\Tenant\\Models\\DatabaseConfig` is not discoverable / not found by PHPStan.
- the full rerun `./vendor/bin/phpstan analyse Modules --debug` is in progress in workspace log `docs/_work/phpstan-modules-2026-03-10-rerun.log`; it is now progressing past the original syntax-stop point.

Tooling note:
- `phpmd` is still not installed in this workspace;
- `phpinsights` still reports structural debt on `PageSchemaBuilder`, so there is still refactor work beyond the correctness fixes.
