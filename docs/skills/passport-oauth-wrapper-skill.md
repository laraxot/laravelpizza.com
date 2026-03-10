# Passport Oauth Wrapper Skill

Usa questa skill mentale quando tocchi Passport o i model OAuth nel modulo `User`.

## Checklist

1. Cerca i model Eloquent nel vendor `laravel/passport/src`.
2. Per ogni model Eloquent, verifica l'esistenza del wrapper `Modules\User\Models\Oauth{Name}`.
3. Verifica che il wrapper estenda la classe `Laravel\Passport\...` originale.
4. Verifica che provider/config del modulo `User` usino i wrapper locali.
5. Aggiungi o aggiorna il test di inventory se Passport cambia.

## Comando rapido di validazione

Eseguire sempre:

`./vendor/bin/pest Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php Modules/User/tests/Unit/Models/PassportModelWrappersTest.php`

## Non confondere

- wrapper obbligatori del vendor Passport
- model OAuth applicativi aggiuntivi del progetto

Esempio: `OauthPersonalAccessClient` e un model locale utile al progetto, ma non deriva da una classe Eloquent del vendor Passport.

## Recovery workflow validato (2026-03-10)

1. Eseguire `./vendor/bin/phpstan analyse Modules/User --error-format=raw`.
2. Se emergono errori su `OauthAccessToken`, verificare che estenda `Laravel\Passport\Token` e non classi non-Eloquent del vendor.
3. Se emergono errori su `tokens` nei PHPDoc di `BaseUser`/`User`, allineare il tipo a `Collection<int, OauthToken>`.
4. Se emergono errori su `OauthPersonalAccessClient`, trattarlo come model locale del modulo, non come wrapper vendor 1:1.
5. Rieseguire `./vendor/bin/phpstan analyse Modules` per validare il delta finale.
