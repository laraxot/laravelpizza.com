---
title: "PgsqlFormatAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Format\\PgsqlFormatAction"
qmd: "PgsqlFormatAction formato trend to_char PostgreSQL duplicato adapter InvalidArgumentException"
---

# PgsqlFormatAction

Formato data PostgreSQL per il trend, come `Trend\Adapters\PgsqlAdapter` ma con `InvalidArgumentException`.

Codice: `app/Actions/Trend/Format/PgsqlFormatAction.php:7-23`.

## Input

- `string $column`, `string $interval`.

## Output

`string`: `to_char(colonna, 'formato')`.

## Invarianti

- `TREND-FMT-PGSQL-INV-1`: formato per intervallo come `PgsqlAdapter`; intervallo non supportato lancia `InvalidArgumentException` (righe 18-19). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`InvalidArgumentException` per intervallo non valido.

## Non fa

- nessun consumer fuori da questa cartella (grep su laravel/Modules).
- Logica duplicata di `PgsqlAdapter`.
