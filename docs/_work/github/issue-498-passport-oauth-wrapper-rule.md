Aggiornata la governance locale per Laravel Passport nel modulo `User`.

Nuova regola operativa:
- ogni classe concreta in `laravel/vendor/laravel/passport/src` che estende `Illuminate\Database\Eloquent\Model` deve avere un wrapper locale `Modules\User\Models\Oauth{NomeClasse}`;
- il wrapper deve estendere direttamente `Laravel\Passport\{NomeClasse}`;
- i binding devono essere centralizzati in `Modules\User\Providers\PassportServiceProvider`.

Verifica effettuata il 2026-03-09:
- modelli Passport Eloquent trovati: `AuthCode`, `Client`, `DeviceCode`, `RefreshToken`, `Token`;
- wrapper locali presenti: `OauthAuthCode`, `OauthClient`, `OauthDeviceCode`, `OauthRefreshToken`, `OauthToken`;
- aggiunto test Pest `Modules/User/tests/Unit/Passport/PassportModelWrappersTest.php` che confronta vendor Passport e wrapper locali e verifica i binding `Passport::*Model()`.

Superfici aggiornate nel repo:
- `AGENTS.md`
- `bashscripts/ai/.cursor/rules/passport-oauth-model-wrappers.md`
- `bashscripts/ai/.cursor/memories/passport-oauth-model-wrappers.md`
- `bashscripts/ai/.cursor/rules/models.md`
- `bashscripts/ai/.codex/skills/php-quality-gates/SKILL.md`

Nota operativa:
- i file guida sotto `bashscripts/ai/.agents/docs/agents-guide/*` risultano attualmente non scrivibili dal mio utente (`664 www-data:www-data`), quindi la regola e' stata fissata nelle superfici scrivibili e nel test automatico.
