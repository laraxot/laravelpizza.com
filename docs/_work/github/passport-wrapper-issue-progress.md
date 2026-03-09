Progress update after docs-first audit of Laravel Passport model wrappers.

Audit result on `vendor/laravel/passport/src`:

- `AuthCode extends Model`
- `Client extends Model`
- `DeviceCode extends Model`
- `RefreshToken extends Model`
- `Token extends Model`

Current `Modules/User/app/Models` coverage:

- `OauthAuthCode` extends `Laravel\Passport\AuthCode`
- `OauthClient` extends `Laravel\Passport\Client`
- `OauthDeviceCode` extends `Laravel\Passport\DeviceCode`
- `OauthRefreshToken` extends `Laravel\Passport\RefreshToken`
- `OauthToken` extends `Laravel\Passport\Token`

So the required wrappers already exist. The missing part was enforcement and documentation.

Changes applied:

- added `laravel/Modules/User/docs/passport-model-wrappers.md`
- updated `laravel/Modules/User/docs/00-index.md`
- added `docs/rules/passport-model-wrapper-rule.md`
- added `docs/memory/passport-model-wrapper-memory.md`
- added `docs/skills/passport-model-wrapper-skill.md`
- added Pest contract test `laravel/Modules/User/tests/Unit/Models/PassportModelWrappersTest.php`

Verification:

- Pest: `1 passed (20 assertions)`
- `php -l` on the new test: OK
- `phpinsights` on the new test: architecture/complexity OK, residual style warning due Pest closure vs static-closure rule conflict
- `phpmd`: not available in current repo (`./vendor/bin/phpmd` missing)
- `phpstan Modules/User`: blocked by many pre-existing syntax errors in legacy migrations/seeders outside this change
