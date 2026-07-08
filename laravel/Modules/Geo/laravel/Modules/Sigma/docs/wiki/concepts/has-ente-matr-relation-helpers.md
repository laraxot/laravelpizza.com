---
title: "trait has ente matr relation helpers"
type: concept
module: Sigma
tags: [ente, matr, relationships, trait, dry, phpstan]
created: 2026-06-15
updated: 2026-06-15
qmd: "HasEnteMatrRelationHelpers hasManyByEnteMatr hasOneByEnteMatr BaseScheda BaseModel"
related:
  - ./ente-matr-field-ownership.md
  - ../../../../Ptv/docs/wiki/concepts/scheda-contract-inheritance.md
  - ../../../../../../docs/wiki/rules/contract-interface-stacking.md
---

# Trait `HasEnteMatrRelationHelpers`

## Scopo

Centralizza `hasManyByEnteMatr()`, `hasOneByEnteMatr()` e `applyRelatedActiveAnnFilter()` estratti da `Sigma\Models\BaseModel`, così anche modelli **fuori** dalla gerarchia Sigma (es. `Ptv\Models\BaseScheda`) possono usare i trait relazione senza duplicare codice.

**Path:** `app/Models/Traits/Concerns/HasEnteMatrRelationHelpers.php`

## Chi lo usa

| Classe | Perché |
|--------|--------|
| `Sigma\Models\BaseModel` | Owner modelli legacy `generale` |
| `Ptv\Models\BaseScheda` | `SchedaTrait` → `EnteMatrRelationship`, `EnteMatrDateRangeRelationship` |

## Prerequisito PHPStan

La classe che `use` il trait deve implementare `EnteMatrFieldsContract` (direttamente o via `SchedaContract`). Per il filtro anno attivo sul related, il target deve implementare `DateRangeFieldsContract`.

## Filtro anno attivo

`applyRelatedActiveAnnFilter()` legge `annFieldName()` **dal modello correlato** — mai hardcodare `'quaann'` / `'stann'` nel chiamante.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Ptv Modules/Sigma
```

## Collegamenti

- [ente-matr-field-ownership](./ente-matr-field-ownership.md)
- [contract-interface-stacking](../../../../../../docs/wiki/rules/contract-interface-stacking.md)
