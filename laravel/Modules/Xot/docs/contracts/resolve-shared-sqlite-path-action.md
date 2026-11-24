---
title: "ResolveSharedSqlitePathAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Testing\\ResolveSharedSqlitePathAction"
qmd: "ResolveSharedSqlitePathAction percorso sqlite condiviso test xot.testing.sqlite_file database test_data"
---

# ResolveSharedSqlitePathAction

Risolve il percorso del file SQLite condiviso dalla suite di test. Codice: `app/Actions/Testing/ResolveSharedSqlitePathAction.php` (classe a riga 20, `execute()` a riga 25).

## Input

- Nessuno. Legge `config('xot.testing.sqlite_file')` e la cartella `database/`.

## Output

- `string`: percorso assoluto.

## Invarianti

- `RESOLVE-SQLITE-INV-1` — Se la config è una stringa non vuota, il percorso è `database_path(config)`. Test: `tests/XotBaseTestCase.php` (menzione).
- `RESOLVE-SQLITE-INV-2` — Altrimenti, se in `database/` c'è esattamente un `*.sqlite`, si usa quello. Test: come sopra.
- `RESOLVE-SQLITE-INV-3` — Negli altri casi: `database/test_data.sqlite`, anche se il file non esiste. Test: come sopra.

## Effetti collaterali

Nessuno: non crea né apre il file.

## Errori

- Il `catch` per `FilesystemException` non si attiva con `glob()`: è codice morto da verificare.

## Non fa

- Non verifica che il file esista.
- Con più file `*.sqlite` ignora la scelta e ritorna il default.
