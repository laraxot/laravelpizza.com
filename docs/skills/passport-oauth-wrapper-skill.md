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
