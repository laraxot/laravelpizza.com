Aggiornamento governance Passport/User del 2026-03-09.

Ho formalizzato la convenzione locale secondo cui ogni model Eloquent concreto di Laravel Passport deve avere il wrapper `Oauth*` nel modulo `User`, cosi' possiamo aggiungere behavior applicativo senza dipendere direttamente dal vendor.

Mappa attuale verificata:
- `Laravel\Passport\AuthCode` -> `Modules\User\Models\OauthAuthCode`
- `Laravel\Passport\Client` -> `Modules\User\Models\OauthClient`
- `Laravel\Passport\DeviceCode` -> `Modules\User\Models\OauthDeviceCode`
- `Laravel\Passport\RefreshToken` -> `Modules\User\Models\OauthRefreshToken`
- `Laravel\Passport\Token` -> `Modules\User\Models\OauthToken`

Enforcement aggiunto:
- regola dedicata in `bashscripts/ai/.cursor/rules/passport-oauth-model-wrappers.md`
- memoria dedicata in `bashscripts/ai/.cursor/memories/passport-oauth-model-wrappers.md`
- skill aggiornata: `bashscripts/ai/.codex/skills/php-quality-gates/SKILL.md`
- test automatico: `Modules/User/tests/Unit/Passport/PassportModelWrappersTest.php`

In pratica: se Passport introduce un nuovo model che estende `Model`, nello stesso change set vanno aggiunti wrapper `Oauth*`, binding in `PassportServiceProvider`, docs/memory e test.
