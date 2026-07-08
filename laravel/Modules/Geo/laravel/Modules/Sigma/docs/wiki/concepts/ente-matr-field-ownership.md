---
title: "ente e matr — ownership colonne relazioni"
type: concept
module: Sigma
tags: [ente, matr, relationships, dry, contract]
created: 2026-06-15
updated: 2026-06-15
qmd: "EnteMatrFieldsContract matrField enteField hasManyByEnteMatr qua00f"
related:
  - ./sigma-model-inheritance.md
  - ./common-scope-date-range-ownership.md
  - ./has-ente-matr-relation-helpers.md
  - ../../../../../../docs/wiki/rules/model-owned-date-range-fields.md
---

# Ente + matricola — ownership colonne

## Perché

Decine di relazioni `qua00f()`, `rep00f()`, `sto00f()` ripetono:

```php
$this->hasMany(Qua00f::class, 'matr', 'matr')->where('ente', $this->ente)
```

Su tabelle legacy i nomi **non** sono sempre `ente`/`matr` (`Dipt00f`: `enteap`/`dtmatr`). Hardcodare le stringhe → bug e duplicazione.

## Naming — perché non `getMatrField()`

| Metodo | Restituisce | Pattern famiglia |
|--------|-------------|------------------|
| `matrField()` / `enteField()` | **Nome colonna** (`'matr'`, `'dtmatr'`) | Come `rangeFromField()`, `annFieldName()` |
| `getMatrAttribute()` / `getEnteAttribute()` | **Valore** attributo (accessor Eloquent) | Prefisso `get` + `Attribute` |

`getMatrField()` creerebbe ambiguità con gli accessor e romperebbe la convenzione metadata senza `get`. Per maggiore chiarezza futura, alternativa accettabile: `matrColumnName()` / `enteColumnName()` (non `get*`).

## Contratto

`Modules\Sigma\Models\Contracts\EnteMatrFieldsContract`:

| Metodo | Default `BaseModel` | Esempio `Dipt00f` |
|--------|---------------------|------------------|
| `matrField()` | `matr` | `dtmatr` |
| `enteField()` | `ente` | `enteap` |

## Helper DRY

`BaseModel::hasManyByEnteMatr($relatedClass)` — usa `matrField()` / `enteField()` sul parent.

Se il correlato implementa `DateRangeFieldsContract`, `hasManyByEnteMatr` applica automaticamente `where(annFieldName(), '')` leggendo il nome colonna **dal modello target** — mai passare `'quaann'` come parametro esterno.

Vedi [model-owned-ann-field-relationships](../../../../../../docs/wiki/rules/model-owned-ann-field-relationships.md).

`EnteMatrRelationship` trait delega al helper. `Sto00f` usa il trait (no duplicati `qua00f`/`rep00f`).

## Decisioni team (2026-06-15)

| Scelta | Esito |
|--------|--------|
| Chiavi figlio | Solo parent (`matrField`/`enteField`) — figlio default `matr`/`ente` |
| Sto00f | `use EnteMatrRelationship` |
| Annullamento | `annFieldName()` sul modello target (`DateRangeFieldsContract`) |
| Rep00f::qua00f | `hasManyByEnteMatr` + `ofRangeDate` (rimosso ente `'90'`) |
| Rollout | Campagna incrementale + audit script |

## Eccezioni

- `Rep00f::qua00f()` — override con `ofRangeDate` e ente fisso legacy (`'90'`): **non** sostituibile con il template standard.
- Relazioni verso colonne non standard sul **figlio** (`Wstr01lx`: `wtmatr`/`enteap`) restano esplicite nel metodo.

## Audit

```bash
bash bashscripts/tools/audit-sigma-ente-matr-fields.sh
```

## Collegamenti

- [sigma-model-inheritance](./sigma-model-inheritance.md)
- [common-scope-date-range-ownership](./common-scope-date-range-ownership.md)
