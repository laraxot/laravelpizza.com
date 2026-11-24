---
title: "GetDistanceExpressionAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Geo\\GetDistanceExpressionAction"
qmd: "GetDistanceExpressionAction distanza geografica espressione SQL latitudine longitudine GeoDistanceExpression"
---

# GetDistanceExpressionAction

Costruisce l'espressione SQL per la distanza tra un punto e le righe. Codice: `app/Actions/Geo/GetDistanceExpressionAction.php` (classe a riga 19, `execute()` a riga 29). L'espressione è `GeoDistanceExpression` in `app/Database/Query/`.

## Input

- `float $latitude`, `float $longitude`: punto di riferimento.
- `?string $alias`: alias opzionale.

## Output

- `Illuminate\Contracts\Database\Query\Expression`: `GeoDistanceExpression`.

## Invarianti

- `GEO-DISTANCE-INV-1` — Ritorna sempre una nuova espressione con i valori ricevuti. Test: nessuno.

## Effetti collaterali

Nessuno: non esegue query.

## Errori

- Nessuno.

## Non fa

- Non valida intervalli di latitudine e longitudine.
- La forma SQL è responsabilità di `GeoDistanceExpression`, non letta da questo contract.
