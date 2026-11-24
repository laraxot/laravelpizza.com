---
title: "SqliteAdapter — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Adapters\\SqliteAdapter"
qmd: "SqliteAdapter trend strftime SQLite intervallo minute hour day month year"
---

# SqliteAdapter

Adapter SQLite per il raggruppamento temporale: produce `strftime(formato, colonna)`.

Codice: `app/Actions/Trend/Adapters/SqliteAdapter.php:10-26`.

## Input

- `string $column`: interpolata senza escaping.
- `string $interval`: minute, hour, day, month, year.

## Output

`string`: `strftime('formato', colonna)`.

## Invarianti

- `TREND-SQLITE-INV-1`: il formato dipende dall'intervallo (righe 15-20); un intervallo non supportato lancia `Error` (riga 21). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`Error` per intervallo non valido.

## Non fa

- La colonna non è escapata.
- nessun consumer fuori da questa cartella (grep su laravel/Modules).
