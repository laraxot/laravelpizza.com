---
title: "ExecuteComposerDumpAutoloadAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ExecuteComposerDumpAutoloadAction"
qmd: "ExecuteComposerDumpAutoloadAction composer dump-autoload autoloader rigenerazione COMPOSER_HOME storage deploy job incompleti"
---

# ExecuteComposerDumpAutoloadAction

Esegue `composer dump-autoload` e nient'altro, per rigenerare l'autoloader senza accesso SSH. Codice: `app/Actions/ExecuteComposerDumpAutoloadAction.php` (classe a riga 22, `execute()` a riga 31).

## Input

- Nessuno.

## Output

- `array{output: list<string>, status: 'completed'|'failed', exitCode: int}`.

## Invarianti

- `COMPOSER-DUMP-INV-1` — Esegue solo `composer dump-autoload` nella radice dell'app, con timeout 120 secondi. Test: `tests/Unit/ComposerNeverRunsInTestsTest.php` (garantisce che il comando non parta nei test).
- `COMPOSER-DUMP-INV-2` — `COMPOSER_HOME` è impostato a `storage/framework/composer-home`, creata se manca. Test: `tests/XotBaseTestCase.php` (menzione).
- `COMPOSER-DUMP-INV-3` — `status` è `failed` solo in base all'exit code; stderr non è etichettato come errore riga per riga. Test: nessuno.

## Effetti collaterali

Crea la cartella `storage/framework/composer-home`. Il processo riscrive i file dell'autoloader in `vendor/composer/`. Nessuna transazione.

## Errori

- `RuntimeException` incapsulando l'eccezione del processo.

## Non fa

- Non esegue `composer install` né aggiorna pacchetti.
- Non passa altre variabili d'ambiente oltre a `COMPOSER_HOME`.
