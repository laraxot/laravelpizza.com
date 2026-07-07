---
title: "HasRelationshipModelClass trait"
type: concept
tags: [xot, filament, phpstan, hasxottable, relation-manager]
created: 2026-06-15
updated: 2026-06-15
qmd: "HasRelationshipModelClass HasXotTable getModelClass RelationManager ManageRelatedRecords"
related:
  - ./filament-v5-hybrid-pattern.md
  - ../../../../../docs/wiki/patterns/phpstan-optional-contracts.md
  - ../log.md
---

# HasRelationshipModelClass

## Problema

`HasXotTable::getModelClass()` deve funzionare su:

- `ListRecords` → `getModel(): string`
- `RelationManager` / `ManageRelatedRecords` → `getRelationship(): Relation|Builder`

Un unico metodo con `method_exists` / `instanceof` misti produce rami morti per PHPStan level max in ogni contesto di classe.

## Soluzione

Trait dedicato **solo** alle classi con relazione Filament:

```php
use HasRelationshipModelClass;
use HasXotTable {
    HasRelationshipModelClass::getModelClass insteadof HasXotTable;
}
```

## Consumer

| Classe base | Path |
|-------------|------|
| `XotBaseRelationManager` | `Filament/Resources/RelationManagers/` e `XotBaseResource/RelationManager/` |
| `XotBaseManageRelatedRecords` | `Filament/Resources/Pages/` e `XotBaseResource/Pages/` |

`HasXotTable` resta su `XotBaseListRecords`, widget e tabelle resource: risolve il modello via `getModel()` string.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Xot/app/Filament/Traits/
```

Con `Xot` in `excludePaths` del neon corrente, verificare tramite scan `Modules` quando Xot è in scope.
