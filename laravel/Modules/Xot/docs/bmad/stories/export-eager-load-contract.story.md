---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Story — contratto getXlsEagerLoad su Resource"
type: story
module: Xot
epic: export
story_id: "export-eager-load-contract"
status: ready
track: feature/export
qmd: "getXlsEagerLoad ExportXlsAction SchedaExporter eager load ratings ratingMorphs contratto Resource de-hardcode"
related:
  - ../../../app/Filament/Actions/Header/ExportXlsAction.php
  - ../../../app/Exports/XotBaseExporter.php
  - ../../../app/Exports/CollectionExport.php
  - ../../../Ptv/app/Filament/Exports/SchedaExporter.php
---

# export-eager-load-contract

## Perche'

`ExportXlsAction` (Xot, generico) oggi hardcoda `['ratings','ratingMorphs']`
con guard `method_exists` — conosce dettagli del dominio Rating. Stesso eager
in `SchedaExporter::modifyQuery`. Funziona ma e' accoppiamento Xot→Rating.

## Proposta

Contratto opzionale sui Resource:

```php
public static function getXlsEagerLoad(): array; // ['ratings','ratingMorphs']
```

- `ExportXlsAction` e `XotBaseExporter` leggono `method_exists($resource,
  'getXlsEagerLoad') ? $resource::getXlsEagerLoad() : []`
- Fallback attuale (guard su model) resta come deprecato o viene rimosso
- `IndennitaResponsabilitaResource`/`SchedaResource` dichiarano le loro relation

## AC

- [ ] Xot non cita piu' `ratings`/`ratingMorphs`
- [ ] Parita' export invariata (test `XotBaseExporterTest` verde)
- [ ] PHPStan 0

## Priorita'

Bassa — refactor di pulizia, non bug. Fare dopo 5.152/5.153 Ptv.
