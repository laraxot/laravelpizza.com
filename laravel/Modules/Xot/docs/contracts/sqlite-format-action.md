---
title: "SqliteFormatAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Format\\SqliteFormatAction"
qmd: "SqliteFormatAction formato trend strftime SQLite duplicato adapter InvalidArgumentException"
---

# SqliteFormatAction

Formato data SQLite per il trend, come `Trend\Adapters\SqliteAdapter` ma con `InvalidArgumentException`.

Codice: `app/Actions/Trend/Format/SqliteFormatAction.php:7-23`.

## Input

- `string $column`, `string $interval`.

## Output

`string`: `strftime('formato', colonna)`.

## Invarianti

- `TREND-FMT-SQLITE-INV-1`: formato per intervallo come `SqliteAdapter`; intervallo non supportato lancia `InvalidArgumentException` (righe 18-19). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`InvalidArgumentException` per intervallo non valido.

## Non fa

- nessun consumer fuori da questa cartella (grep su laravel/Modules).
- Logica duplicata di `SqliteAdapter`.
