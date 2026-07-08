---
title: "Filament tableFilters nullable"
module: "IndennitaCondizioniLavoro"
type: concept
tags: [phpstan, filament, tablefilters, actions]
created: 2026-06-18
updated: 2026-06-18
qmd: "indennita condizioni lavoro filament tableFilters nullable makepdf replicateindennita phpstan"
issues:
  - "https://github.com/provtv/base_ptv_fila5_mono/issues/136"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - "../../phpstan-filament5-tablefilters.md"
  - "../../phpstan-improvements.md"
  - "../../../../../../docs/wiki/phpstan/filament-tablefilters-nullable.md"
---

# Filament tableFilters nullable

> Le action `MakePdf` e `ReplicateIndennita` ricevono filtri da header action Filament; il contratto deve accettare `array|null` e validare prima di usare i dati.

## Decisione

`MakePdf::execute()` e `ReplicateIndennita::execute()` accettano `?array`:

- `null` rappresenta filtri assenti;
- input non-array genera `InvalidArgumentException`;
- filtri validi restano supportati sia in forma nested `anno/valutatore` sia flat;
- le callback Filament non richiedono suppressioni per `argument.type`.

## Test

I test owner coprono:

- estrazione filtri nested;
- fallback flat;
- eccezione su campi obbligatori mancanti;
- eccezione su `tableFilters` null.

## Verifica

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/IndennitaCondizioniLavoro
./vendor/bin/pest Modules/IndennitaCondizioniLavoro/tests
```

## Related

- [Nota storica tableFilters](../../phpstan-filament5-tablefilters.md)
- [Pattern root](../../../../../../docs/wiki/phpstan/filament-tablefilters-nullable.md)
