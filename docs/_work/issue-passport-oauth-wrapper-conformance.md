## Obiettivo
Garantire che ogni classe in `vendor/laravel/passport/src` che estende `Model` abbia un wrapper in `Modules/User/app/Models` con prefisso `Oauth` che estende la classe `Laravel\\Passport\\*` originale.

## Audit eseguito
Classi Passport che estendono `Model`:
- `Laravel\\Passport\\Client`
- `Laravel\\Passport\\Token`
- `Laravel\\Passport\\AuthCode`
- `Laravel\\Passport\\RefreshToken`
- `Laravel\\Passport\\DeviceCode`

Wrapper presenti in modulo User:
- `OauthClient`
- `OauthToken`
- `OauthAuthCode`
- `OauthRefreshToken`
- `OauthDeviceCode`

## Azioni pianificate
1. Aggiungere test Pest di conformità mapping Passport -> Oauth wrappers.
2. Aggiornare docs modulo User con tabella mapping ufficiale.
3. Aggiornare regola globale + memory + skill su questa convenzione.
4. Pubblicare esito finale su issue/discussion.
