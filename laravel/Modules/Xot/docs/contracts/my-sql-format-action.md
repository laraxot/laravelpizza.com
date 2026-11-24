---
title: "MySqlFormatAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Format\\MySqlFormatAction"
qmd: "MySqlFormatAction formato trend date_format MySQL duplicato adapter InvalidArgumentException"
---

# MySqlFormatAction

Formato data MySQL per il trend, come `Trend\Adapters\MySqlAdapter` ma con `InvalidArgumentException`.

Codice: `app/Actions/Trend/Format/MySqlFormatAction.php:7-23`.

## Input

- `string $column`, `string $interval`.

## Output

`string`: `date_format(colonna, 'formato')`.

## Invarianti

- `TREND-FMT-MYSQL-INV-1`: formato per intervallo come `MySqlAdapter`; intervallo non supportato lancia `InvalidArgumentException` (righe 18-19). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`InvalidArgumentException` per intervallo non valido.

## Non fa

- nessun consumer fuori da questa cartella (grep su laravel/Modules).
- Logica duplicata di `MySqlAdapter`; differisce solo per la classe dell'eccezione.
