Architecture note for Passport model governance in `Modules/User`.

After auditing `vendor/laravel/passport/src`, the current Passport Eloquent models are:

- `AuthCode`
- `Client`
- `DeviceCode`
- `RefreshToken`
- `Token`

Each of them already has a local wrapper in `Modules/User/app/Models` with the `Oauth*` prefix.

The real gap was not missing code, but missing governance. I have now fixed that by:

- documenting the one-to-one mapping in module docs;
- adding global rule/memory/skill docs so future work keeps using local wrappers instead of vendor models directly;
- adding a Pest conformity test that fails if a Passport Eloquent model loses its `Oauth*` wrapper.

This keeps the integration DRY/KISS:

- no unnecessary refactor of existing working wrappers;
- one explicit contract for future Passport upgrades;
- one automated regression test.
