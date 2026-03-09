Progress update:

- completed the vendor Passport audit and confirmed that all current Passport Eloquent models are already wrapped locally under `Modules\User\Models\Oauth*`;
- added an automated inventory test so this convention becomes enforceable instead of tribal knowledge;
- documented the rule in local rules/memory/skill docs and in module-specific User docs.

Concrete outcome:

- no missing wrapper had to be created today;
- the real improvement is that future Passport upgrades will now fail fast if a new vendor Eloquent model appears without a matching `Oauth*` wrapper.

Verified with:

- `./vendor/bin/pest Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php`

Current nuance captured in docs:

- `OauthPersonalAccessClient` remains a valid local OAuth model, but it is not part of the strict 1:1 vendor Passport wrapper parity because Passport does not expose it as a root Eloquent model in `src/`.
