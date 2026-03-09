# Passport Model Wrapper Rule

## Regola vincolante

Quando una libreria vendor espone model Eloquent usati dal dominio applicativo, non vanno referenziati in modo diffuso nel codice di business se il modulo puo' fornire un wrapper locale stabile.

Per `laravel/passport`, ogni classe sotto `vendor/laravel/passport/src` che estende `Model` deve avere un wrapper in `Modules/User/app/Models` con lo stesso nome preceduto da `Oauth`.

## Obiettivo

- estendere il vendor senza fork;
- mantenere DRY e controllo locale del comportamento;
- centralizzare connessione, policy e relazioni nel modulo `User`.

## Esempio corretto

- `Laravel\Passport\DeviceCode` -> `Modules\User\Models\OauthDeviceCode`

## Esempio operativo

Prima di introdurre un uso nuovo di un model vendor Passport:

1. verificare se il wrapper `Oauth*` esiste;
2. se manca, creare il wrapper nel modulo `User`;
3. aggiungere test Pest di conformita' per il mapping.
