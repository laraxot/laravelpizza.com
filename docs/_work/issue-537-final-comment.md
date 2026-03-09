Audit completato.

## Risultato tecnico
In `vendor/laravel/passport/src` le classi che estendono `Model` sono 5:
- `AuthCode`
- `Client`
- `DeviceCode`
- `RefreshToken`
- `Token`

Nel modulo User i wrapper `Oauth*` corrispondenti sono tutti presenti e conformi:
- `OauthAuthCode` -> `Laravel\\Passport\\AuthCode`
- `OauthClient` -> `Laravel\\Passport\\Client`
- `OauthDeviceCode` -> `Laravel\\Passport\\DeviceCode`
- `OauthRefreshToken` -> `Laravel\\Passport\\RefreshToken`
- `OauthToken` -> `Laravel\\Passport\\Token`

## Test eseguiti
Comando:
`./vendor/bin/pest Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php Modules/User/tests/Unit/Models/PassportModelWrappersTest.php --compact`

Esito:
- `2 passed` (`31 assertions`)

## Docs aggiornate
- `Modules/User/docs/passport-oauth-wrapper-conformance.md` (nuovo)
- `Modules/User/docs/index.md` (link aggiunto)
- `docs/rules/passport-oauth-wrapper-rule.md` (verifica periodica)
- `docs/memory/passport-oauth-wrapper-memory.md` (snapshot verifica)
- `docs/skills/passport-oauth-wrapper-skill.md` (comando rapido validazione)

Nessuna nuova classe PHP necessaria: la conformità richiesta è già rispettata nel codice corrente.
