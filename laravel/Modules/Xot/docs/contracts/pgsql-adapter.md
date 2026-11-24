---
title: "PgsqlAdapter — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Adapters\\PgsqlAdapter"
qmd: "PgsqlAdapter trend to_char PostgreSQL intervallo minute hour day month year"
---

# PgsqlAdapter

Adapter PostgreSQL per il raggruppamento temporale: produce `to_char(colonna, formato)`.

Codice: `app/Actions/Trend/Adapters/PgsqlAdapter.php:10-26`.

## Input

- `string $column`: interpolata senza escaping.
- `string $interval`: minute, hour, day, month, year.

## Output

`string`: `to_char(colonna, 'formato')`.

## Invarianti

- `TREND-PGSQL-INV-1`: il formato dipende dall'intervallo (righe 15-20); un intervallo non supportato lancia `Error` (riga 21). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`Error` per intervallo non valido.

## Non fa

- La colonna non è escapata.
- nessun consumer fuori da questa cartella (grep su laravel/Modules).
