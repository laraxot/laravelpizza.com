# Passport Model Wrapper Memory

## Snapshot

- Regola utente consolidata: i model `Laravel\Passport` che estendono `Model` devono avere wrapper locali `Oauth*` in `Modules/User/app/Models`.
- Il punto non e' solo naming: serve un layer locale governabile dal sistema.
- La copertura minima deve essere automatica con test Pest sul mapping vendor -> wrapper.

## Mapping atteso

- `AuthCode` -> `OauthAuthCode`
- `Client` -> `OauthClient`
- `DeviceCode` -> `OauthDeviceCode`
- `RefreshToken` -> `OauthRefreshToken`
- `Token` -> `OauthToken`
