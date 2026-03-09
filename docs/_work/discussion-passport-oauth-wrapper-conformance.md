## Proposta di convenzione stabile

Ogni classe in `vendor/laravel/passport/src` che estende `Model` deve avere nel modulo User una classe omologa con prefisso `Oauth` che estende la classe Passport originale.

### Mapping corrente verificato
- `Laravel\\Passport\\Client` -> `Modules\\User\\Models\\OauthClient`
- `Laravel\\Passport\\Token` -> `Modules\\User\\Models\\OauthToken`
- `Laravel\\Passport\\AuthCode` -> `Modules\\User\\Models\\OauthAuthCode`
- `Laravel\\Passport\\RefreshToken` -> `Modules\\User\\Models\\OauthRefreshToken`
- `Laravel\\Passport\\DeviceCode` -> `Modules\\User\\Models\\OauthDeviceCode`

Issue collegata: #537

### Perche'
- centralizzare override di connessione/table/comportamento nel modulo User
- evitare dipendenza diretta dai model vendor nel dominio applicativo
- mantenere estendibilita' futura senza patchare vendor

### Step operativi
1. Test Pest automatico di conformità mapping.
2. Regola docs/rules + memory + skill dedicata.
3. Aggiornamento periodico quando cambia Passport.
