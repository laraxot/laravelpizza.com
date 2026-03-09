Progress update on the Passport wrapper convention:

- audited `laravel/vendor/laravel/passport/src` and isolated the vendor classes that actually extend Eloquent `Model`:
  - `Laravel\Passport\AuthCode`
  - `Laravel\Passport\Client`
  - `Laravel\Passport\DeviceCode`
  - `Laravel\Passport\RefreshToken`
  - `Laravel\Passport\Token`
- confirmed that the corresponding local wrappers already exist in `Modules/User/app/Models`:
  - `OauthAuthCode`
  - `OauthClient`
  - `OauthDeviceCode`
  - `OauthRefreshToken`
  - `OauthToken`

So the right fix was not inventing new classes, but enforcing the convention to prevent future regressions.

Implemented:

- new regression test:
  - `Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php`
- local governance docs:
  - `docs/rules/passport-oauth-wrapper-rule.md`
  - `docs/memory/passport-oauth-wrapper-memory.md`
  - `docs/skills/passport-oauth-wrapper-skill.md`
- module doc:
  - `Modules/User/docs/passport-oauth-wrapper-convention.md`

Verification:

- `./vendor/bin/pest Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php`
- result: `1 passed (11 assertions)`

Important nuance documented:

- `OauthPersonalAccessClient` is a local project model, not a 1:1 wrapper of a vendor Passport Eloquent model, so it is outside the strict parity rule.
