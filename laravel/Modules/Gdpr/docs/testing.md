---
title: "Test del modulo Gdpr"
type: guide
module: Gdpr
updated: 2026-11-25
---

# Test

45 file in `tests/` (verificato 2026-11-25): Pest per i test nuovi, qualche classe PHPUnit storica.

## Come si lanciano

Dalla radice del monorepo, sul database usa-e-getta (clona la sola struttura dai database di sviluppo, nessuna scrittura
sul DB di sviluppo, lo elimina in uscita):

```bash
bash bashscripts/tools/pest-scratch-db.sh Modules/Gdpr/tests/Unit/Providers/CookieConsentWiringTest.php
bash bashscripts/tools/pest-scratch-db.sh Modules/Gdpr/tests
```

Dalla cartella `laravel/`: `vendor/bin/pest Modules/Gdpr/tests --group=<ID>` per le invarianti dei contratti
(es. `--group=GDPR-SAVE-INV-3`, vedi [contracts/README.md](contracts/README.md)). Se `setUp` fallisce con "Unknown database",
si e' osservato che va lanciato con `DB_DATABASE_USER=` vuoto. Mai `RefreshDatabase`, mai `migrate:fresh` o `--force`: i dati sono
sacri; l'isolamento e' `DatabaseTransactions`.

## Come e' fatta la base

- `tests/TestCase.php` estende `XotBaseTestCase` (il database di prova e' deciso li': `prepareSharedSqliteForTesting()`),
  usa `DatabaseTransactions`, registra `UserServiceProvider` e `GdprServiceProvider`, imposta `auth.providers.users.model`
  e tiene `$currentTest` per gli helper.
- `tests/Pest.php` include `PestHelpers.php` (`gdprGet()`, `gdprPost()`, `createGdprConsent()`, ...) e `PestStubs.php`. **Non lega
  il TestCase**: Pest legge solo `laravel/tests/Pest.php`, quindi **ogni file di test dichiara
  `uses(\Modules\Gdpr\Tests\TestCase::class)`**; senza, il test gira su un container vuoto (errore tipico:
  `Target class [config] does not exist`). Non forzare SQLite o connessioni in memoria nel `setUp`, non creare tabelle a mano:
  le migrazioni sono quelle del modulo.
- Fixture: `tests/Fixtures/HasGdprDummy.php` esercita il trait `HasGdpr` senza modello finto in `app/`.

## Cosa copre

| Area | File |
|---|---|
| Registrazione (pagina, validazione, localizzazione, esito) | `Feature/Register*Test.php`, `Registration*Test.php`, `SimpleRegisterTest.php`, `Feature/Auth/RegisterPageTest.php` |
| Contratto con il tema | `Feature/RegisterWidgetContractTest.php` (vedi [register-widget-copy-ownership.md](register-widget-copy-ownership.md)) |
| Logica dei consensi | `Feature/GdprBusinessLogicTest.php`, `Unit/Actions/*` (Save, Collect, Validate*, HandleRegistration*, Revoke), `Unit/Listeners/SaveGdprConsentsTest.php`, `Unit/Traits/HasGdprTraitTest.php`, `Unit/Models/*` |
| Cablaggio del banner cookie | `Unit/Providers/CookieConsentWiringTest.php` (guardia, [cookie-banner.md](cookie-banner.md)) |
| Provider, pannello, config | `Unit/Providers/*`, `Unit/Datas/GdprConfigDataTest.php`, `Unit/Filament/Resources/*` |
| Connessione | `Feature/DatabaseConnectionTest.php` |

Invarianti con group Pest: `GDPR-SAVE-INV-1..5` in `Unit/Actions/SaveGdprConsentsActionTest.php` (intercetta gli INSERT su
`consents` con l'evento `creating`).

## Debito

- Nessun test esercita `DeleteAccountAction`; `RevokeGdprConsentsActionTest` e' una classe PHPUnit senza group che fallisce prima
  di arrivare all'Action (la tabella `users` del database di prova condiviso non ha la colonna `state` che la `UserFactory`
  scrive): convertirla in Pest quando torna verde e aggiungere i group `GDPR-REVOKE-INV-*`.
- Alcuni test usano la facade `Assert::` dentro funzioni Pest: stile da uniformare a `expect()`.
- Nessun valore di coverage aggiornato: misurare con `pest --coverage` (obiettivo del repository: 80%).

## Registrare un test nuovo

Pest, nel modulo owner (`Modules/Gdpr/tests/{Unit,Feature}`), nome che descrive il comportamento, struttura Arrange-Act-Assert,
`uses(\Modules\Gdpr\Tests\TestCase::class)` in cima, e una guardia di **cablaggio** (non solo di codice) per ogni cosa che i mirror
possono riportare indietro, come il provider del banner.
