---
title: "MySqlAdapter — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Adapters\\MySqlAdapter"
qmd: "MySqlAdapter trend date_format MySQL intervallo minute hour day month year"
---

# MySqlAdapter

Adapter MySQL per il raggruppamento temporale: produce `date_format(colonna, formato)`.

Codice: `app/Actions/Trend/Adapters/MySqlAdapter.php:10-26`.

## Input

- `string $column`: interpolata senza escaping.
- `string $interval`: minute, hour, day, month, year.

## Output

`string`: `date_format(colonna, 'formato')`.

## Invarianti

- `TREND-MYSQL-INV-1`: il formato dipende dall'intervallo (righe 15-20); un intervallo non supportato lancia `Error` (riga 21). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

`Error` (non `Exception`) per intervallo non valido: non è catturato dai normali `catch (\Exception)`.

## Non fa

- La colonna non è escapata: non passare input utente.
- nessun consumer fuori da questa cartella (grep su laravel/Modules).
