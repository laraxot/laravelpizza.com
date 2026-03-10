Final progress update on the current `phpstan analyse Modules` recovery wave.

What was fixed in this pass:

- repaired syntax-corrupted `Cms` files:
  - `laravel/Modules/Cms/database/Migrations/2024_01_01_000000_create_page_contents_table.php`
  - `laravel/Modules/Cms/database/seeders/CmsMassSeeder.php`
- repaired broken OAuth factories in `Modules/User`:
  - `OauthClientFactory`
  - `OauthAccessTokenFactory`
  - `OauthAuthCodeFactory`
  - `OauthRefreshTokenFactory`
- repaired additional low-risk `User` quality blockers:
  - `database/seeders/UserMassSeeder.php`
  - `database/seeders/RolesSeeder.php`
  - `database/factories/TenantFactory.php`
- added regression coverage:
  - `laravel/Modules/User/tests/Unit/Database/OauthFactoriesDefinitionTest.php`

Measured results:

- full `./vendor/bin/phpstan analyse Modules --no-progress` is now green
- recovery path in this wave: `171` errors -> `106` errors -> `0`
- focused PHPStan on touched Cms/User/Passport clusters is green
- Pest on the added OAuth factory coverage is green: `3 passed (43 assertions)`
- PHP Insights on the targeted User files runs successfully and stays in the high 80s/90s range
- PHPMD on the latest Passport/User files still reports non-blocking design/style findings (boolean flags, static access, complexity), but no syntax/type blockers relevant to PHPStan

Docs updated:

- `laravel/Modules/Cms/docs/phpstan-syntax-blockers-2026-03-10.md`
- `laravel/Modules/User/docs/phpstan-syntax-blockers-2026-03-10.md`
- `laravel/Themes/Meetup/docs/phpstan-module-blockers-impact-2026-03-10.md`

Additional cluster finished after the intermediate update:

- `User/Passport` wrapper typing and Filament resource model bindings
- wrapper PHPDoc completion for `OauthClient` and `OauthRefreshToken`
- local PHPStan-safe handling for Passport wrapper `$model` resource bindings

Next recommended wave:

1. reduce PHPMD/PHP Insights debt on the Passport Filament resources
2. add dedicated regression tests for the previously broken Cms/User clusters
3. keep docs in sync with the fact that global PHPStan on `Modules` is green again
