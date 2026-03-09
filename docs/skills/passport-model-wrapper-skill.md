# Skill Operativa: Passport Model Wrapper

## Trigger

Usare questa skill quando si toccano integrazioni `laravel/passport` o model OAuth nel modulo `User`.

## Procedura

1. leggere `vendor/laravel/passport/src` e identificare le classi che estendono `Model`;
2. confrontarle con `Modules/User/app/Models/Oauth*.php`;
3. per ogni model vendor mancante, creare un wrapper locale con naming `Oauth{Name}`;
4. fare estendere al wrapper la classe `Laravel\Passport\...` originale;
5. aggiungere o aggiornare il test Pest che verifica il mapping;
6. eseguire quality gate post-edit sui file PHP toccati.

## Output minimo

- mapping documentato;
- wrapper locali completi;
- test Pest verde che impedisce regressioni future.
