---
title: "AbstractAdapter — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\Adapters\\AbstractAdapter"
qmd: "AbstractAdapter adapter trend SQL formato data strategia classe astratta format"
---

# AbstractAdapter

Classe astratta per gli adapter SQL del trend: definisce `format(column, interval)`.

Codice: `app/Actions/Trend/Adapters/AbstractAdapter.php:11-14`.

## Input

- `string $column`, `string $interval`.

## Output

`string`: espressione SQL di formato data (dalle sottoclassi).

## Invarianti

- `TREND-ADAPT-INV-1`: ogni sottoclasse deve implementare `format` (riga 13). Test: nessuno; garantito da PHP.

## Effetti collaterali

Nessuno.

## Errori

Nessuna eccezione propria.

## Non fa

- nessun consumer fuori da questa cartella (grep su laravel/Modules).
- Il docblock la descrive come "Kind B" (adapter/strategy non QueueableAction).
