# Passport Oauth Wrapper Rule

Quando un model del vendor `Laravel\Passport` estende `Illuminate\Database\Eloquent\Model`, il codice applicativo non deve usarlo direttamente come model canonico del progetto.

Serve un wrapper locale in:

- `laravel/Modules/User/app/Models/Oauth{Name}.php`

Esempi:

- `Laravel\Passport\Client` -> `Modules\User\Models\OauthClient`
- `Laravel\Passport\Token` -> `Modules\User\Models\OauthToken`
- `Laravel\Passport\AuthCode` -> `Modules\User\Models\OauthAuthCode`
- `Laravel\Passport\RefreshToken` -> `Modules\User\Models\OauthRefreshToken`
- `Laravel\Passport\DeviceCode` -> `Modules\User\Models\OauthDeviceCode`

## Motivo

- centralizzare connection, policy e personalizzazioni future
- evitare dipendenze sparse dal vendor Passport nel codice applicativo
- mantenere un layer stabile del modulo `User`

## Regola operativa

1. Se Passport aggiunge un nuovo model Eloquent, creare subito il wrapper `Oauth*`.
2. I provider/config del modulo `User` devono referenziare i wrapper locali.
3. Il controllo deve essere coperto da test automatico.

## Verifica periodica obbligatoria

- Eseguire `Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php`.
- Eseguire `Modules/User/tests/Unit/Models/PassportModelWrappersTest.php`.
- Se i test falliscono, prima si aggiorna il mapping wrappers, poi il codice applicativo.

## Nota

`OauthPersonalAccessClient` e altri model OAuth locali senza equivalente Eloquent diretto nel vendor non rientrano nella regola di parita 1:1 col vendor; sono model applicativi aggiuntivi.

## Fix pattern confermato (2026-03-10)

- `OauthClient` -> wrapper di `Laravel\Passport\Client`
- `OauthToken` -> wrapper di `Laravel\Passport\Token`
- `OauthAuthCode` -> wrapper di `Laravel\Passport\AuthCode`
- `OauthRefreshToken` -> wrapper di `Laravel\Passport\RefreshToken`
- `OauthDeviceCode` -> wrapper di `Laravel\Passport\DeviceCode`
- `OauthPersonalAccessClient` -> model locale del modulo `User`, con tabella `oauth_personal_access_clients` e relazione `client()` verso `OauthClient`

Quando PHPStan segnala generic subtype errors sui token o relazioni OAuth, la prima verifica va fatta su questa distinzione.
