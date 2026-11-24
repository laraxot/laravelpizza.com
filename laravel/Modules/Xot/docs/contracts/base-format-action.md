---
title: "BaseFormatAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Format\\BaseFormatAction"
qmd: "BaseFormatAction formato trend classe astratta QueueableAction execute colonna intervallo SQL"
---

# BaseFormatAction

Classe astratta delle Action di formato data SQL del trend. Duplica il ruolo di `AbstractAdapter`.

Codice: `app/Actions/Trend/Format/BaseFormatAction.php:9-14`.

## Input

- `string $column`, `string $interval`.

## Output

`string`: espressione SQL di formato (dalle sottoclassi).

## Invarianti

- `TREND-FMT-BASE-INV-1`: ogni sottoclasse deve implementare `execute` (riga 13). Test: nessuno; garantito da PHP.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- nessun consumer fuori da questa cartella (grep su laravel/Modules).
- Duplica `Trend\Adapters\AbstractAdapter`: candidata a fusione.
