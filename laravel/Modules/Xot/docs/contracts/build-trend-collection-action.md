---
title: "BuildTrendCollectionAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trend\\BuildTrendCollectionAction"
qmd: "BuildTrendCollectionAction trend serie temporale aggregato count avg min max sum flowframe TrendData intervallo"
---

# BuildTrendCollectionAction

Costruisce una serie temporale aggregata da una query con `Flowframe\Trend`.

Codice: `app/Actions/Trend/BuildTrendCollectionAction.php:16-64`.

## Input

- `Builder $query`, `Carbon $start`, `Carbon $end`.
- `string $interval` (default `day`), `string $dateColumn` (default `created_at`), `string $dateAlias` (default `date`), `string $aggregateColumn` (default `*`), `string $aggregate` (default `count`).

## Output

`Collection<int, TrendData>` con `date` e `aggregate`.

## Invarianti

- `TREND-BUILD-INV-1`: un aggregato diverso da avg, min, max, sum, count lancia `InvalidArgumentException` (riga 48). Test: Nessun test dedicato.
- `TREND-BUILD-INV-2`: un valore non `TrendValue` lancia `UnexpectedValueException` (righe 53-55). Test: Nessun test dedicato.
- `TREND-BUILD-INV-3`: l'intervallo e la colonna sono passati a `Trend` senza validazione in questa Action; la validazione degli intervalli in `Trend/Format` non è usata qui (da verificare nel pacchetto). Test: Nessun test dedicato.
- `TREND-BUILD-INV-4`: la collezione restituita è reindicizzata con `values()` (riga 62). Test: Nessun test dedicato.

## Effetti collaterali

Lettura DB con aggregazione. Nessuna scrittura.

## Errori

`InvalidArgumentException` per aggregato non supportato; `UnexpectedValueException` per valore non valido.

## Non fa

- Nessun limite di intervalli: l'intervallo può essere molto ampio.
- nessun consumer fuori da questa cartella (grep su laravel/Modules).
