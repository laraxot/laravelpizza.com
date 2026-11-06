---
title: "Rimozione @phpstan-ignore da Geo (HasAddress, HasPlaceTrait)"
type: story
module: Geo
status: done
created: 2026-10-30
updated: 2026-10-30
tags: [phpstan, geo, trait, phpstan-ignore]
qmd: "phpstan-ignore-removal geo"
---

# Rimozione @phpstan-ignore da Geo

Regola del progetto: mai `@phpstan-ignore`, mai baseline.

## Esito

| File | Prima | Dopo | Correzione |
|---|---|---|---|
| `app/Models/Traits/HasAddress.php` | 4 | 0 | Le 4 annotazioni (`missingType.iterableValue` x2, `argument.type` x2) erano obsolete: il `@param array<string, mixed>` e' gia' presente e PHPStan non segnala piu' nulla. Tolte senza altre modifiche. |
| `app/Models/Traits/HasPlaceTrait.php` | 2 | 0 | Aggiunti `@return MorphOne<Place, $this>` e `@return MorphMany<Place, $this>` (generics mancanti) e `@phpstan-require-extends Model` sul trait. |

PHPStan pulito su entrambi i file, sul fixture `HasAddressTestModel`, sul probe `HasPlaceTraitPhpstanProbe` e su `TechPlanner\Models\Client` (usa `HasAddress`). Nessun cambio di comportamento.

## Non rimosso (con motivo)

Nulla in questo modulo.

## Non verificato

- Analisi completa `analyse Modules` (spetta al coordinatore).
- Pest non eseguito (il DB di test contiene dati reali).
