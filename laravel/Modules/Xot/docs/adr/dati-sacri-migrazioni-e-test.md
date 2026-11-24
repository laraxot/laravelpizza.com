---
title: "I dati sono sacri: mai migrate:fresh/reset/rollback/force, mai RefreshDatabase, test solo con .env.testing"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-24
decision-makers: [team back office]
issues: [251]
---

# I dati sono sacri: migrazioni e test girano solo in avanti

## Contesto

La base contiene dati reali e multi-tenant: ogni modulo ha il proprio database e i test condividono gli stessi spazi. `migrate:fresh`, `migrate:refresh`, `migrate:reset`, `migrate:rollback` e `db:wipe` distruggono o riscrivono lo stato che nessun rollback ripristina. `RefreshDatabase` nei test resetta tabelle condivise, rompe l'isolamento multi-tenant e crea race condition tra test paralleli. Eseguire i test senza `.env.testing` punta i test al database di sviluppo.

## Driver della decisione

- Irreversibilità: un `fresh` su un database condiviso non si annulla.
- Isolamento multi-tenant: la base ha piú connessioni (`DB_*`, `DB_DATABASE_LIMESURVEY`, suffisso `_test` obbligatorio).
- Riproducibilità: i test devono girare sempre sullo stesso ambiente dichiarato, mai su dati reali.

## Alternative scartate

- `migrate:fresh`/`refresh`/`reset`/`rollback`, `db:wipe` o opzioni distruttive `--force` per "sistemare" lo stato: rifiutati sempre, su qualunque ambiente.
- `RefreshDatabase` trait nei test Pest: vietato, usa `DatabaseTransactions` o cleanup esplicito.
- Test senza `.env.testing`, con fallback su `.env`, `.env.sqlite` o con SQLite/`:memory:`: vietati, la base è progettata per MySQL multi-database.

## Decisione

Scelta: **regola permanente**, perché i dati sono sacri e l'isolamento multi-tenant non si negozia. In pratica:

- Vietati `php artisan migrate:fresh`, `migrate:reset`, `migrate:rollback`, `migrate --force` e `git push --force` (e equivalenti): si studia la storia con `git log`/`show`/`blame` e si riscrive in avanti.
- Vietato `use Illuminate\Foundation\Testing\RefreshDatabase` in ogni test: si usa `DatabaseTransactions` o cleanup manuale.
- `.env.testing` deve esistere prima di avviare qualunque test; il bootstrap fallisce esplicitamente se manca. Deve contenere database MySQL locali usa-e-getta con suffisso `_test`; non si copia su `.env` e non si usa un fallback implicito.

## Conseguenze

- Buono, perché nessun agente o sviluppatore può cancellare dati reali per errore o disattenzione.
- Buono, perché i test non perdono isolamento ne' toccano i database di sviluppo.
- Cattivo, perché una migrazione sbagliata va corretta con una migrazione successiva (forward-only), non con un reset: a volte costa piú lavoro.

## Conferma

- In revisione: un comando `migrate:fresh|reset|rollback`, `--force` o `RefreshDatabase` in codice o script si respinge con un rimando a questo ADR.
- `Modules/Xot/tests/Support/TestDatabaseGuard.php` rifiuta ambiente diverso da `testing`, database senza suffisso `_test` e host remoti.
- `Modules/Xot/tests/CreatesApplication.php` rifiuta l'assenza di `.env.testing`.
- `Modules/Xot/tests/Arch/` (ArchitectureTest) e le skill `git-forward-only`, `laravel-tdd`, `agents.md` (sezione testing) citano questo ADR come riferimento.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Harness/GuardTest.php`: il guard PreToolUse
  (`.harness/bin/guard`) blocca `migrate:fresh`, `migrate:refresh`, `db:wipe`, la scrittura del trait di reset del
  database nei test e i comandi git che riavvolgono la storia (`reset --hard`, `checkout`, `restore`, push forzato);
  ogni regola ha un caso che scatta e uno vicino che passa (`Modules/Xot/tests/Unit/Harness/GuardTest.php`).
- `Modules/Xot/tests/Support/TestDatabaseGuard.php` ferma i test prima del primo caso se una connessione non punta a un
  database `_test` locale; `Modules/Xot/tests/CreatesApplication.php` lancia un'eccezione se `.env.testing` manca.
- Solo revisione: `migrate:reset`, `migrate:rollback` e `migrate --force` non sono coperti dal guard.
