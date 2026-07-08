---
title: "Relationships Audit - HasMany matr/ente Pattern"
type: "patterns"
tags: ["dry", "kiss", "relationships", "audit"]
created: "2026-06-15"
updated: "2026-06-15"
---

# Relationships Audit - HasMany matr/ente Pattern

## Obiettivo

Audit completo dei metodi `qua00f()`, `rep00f()`, `sto00f()`, `qua00k1()`, `ana02f()` che implementano relazioni HasMany con filtro `matr` + `ente`.

## Pattern DRY Implementato

```
BaseModel::hasManyByEnteMatr(Qua00f::class)
    → Usa $this->matrField()  # default 'matr'
    → Usa $this->{$this->enteField()}  # default 'ente'
    → Filtro annFieldName() automatico via applyRelatedActiveAnnFilter()
```

## Inventario Metodi

### qua00f() - Relazione a Qualifiche

| Modello | File | Implementazione | Note |
|---|---|---|---|
| `Sto00f` | Models/Sto00f.php | ✅ Trait | USA `EnteMatrRelationship` |
| `Rep00f` | Models/Rep00f.php:255 | ✅ Trait | USA `hasManyByEnteMatr` + `ofRangeDate()` |
| `Asz00k1` | Models/Asz00k1.php:231 | ✅ Trait | USA `hasManyByEnteMatr` |
| `Dipt00f` | Traits/EnteMatrRelationship.php:84 | ✅ Trait | USA `hasManyByEnteMatr` |
| `Employee` | Modules/Incentivi/Models/Employee.php:188 | ❌ Hardcoded | DA AUDIT |

### rep00f() - Relazione a Reparti

| Modello | File | Implementazione | Note |
|---|---|---|---|
| `Sto00f` | Traits/EnteMatrRelationship.php:72 | ✅ Trait | Filtro `stann = ''` |
| `Qua00f` | Models/Qua00f.php:308 | ❌ Hardcoded | DA AUDIT |
| `LettF` | Modules/IndennitaResponsabilita/Models/LettF.php:340 | ❌ Custom | `rep00fByAnno()` |

### sto00f() - Relazione a Storico

| Modello | File | Implementazione | Note |
|---|---|---|---|
| Trait | Traits/EnteMatrRelationship.php:78 | ✅ Trait | Filtro `stann = ''` |

### qua00k1() - Relazione a Qualifiche Extended

| Modello | File | Implementazione | Note |
|---|---|---|---|
| `Sto00f` | Traits/Qua00k1Relationship.php:22 | ✅ Trait Nuovo | Filtro `quaann = ''` |
| `Asz00k1` | Models/Asz00k1.php:219 | ✅ Trait | `qua00fsimple()` separato |

### ana02f() - Relazione a Anagrafica Esterna

| Modello | File | Implementazione | Note |
|---|---|---|---|
| Trait | Traits/EnteMatrRelationship.php:55 | ✅ Trait | Filtro `anaann = ''` |
| `Qua00f` | Models/Qua00f.php:297 | ❌ Duplicato | DA AUDIT |

## Modelli con Override matrField()/enteField()

| Modello | matrField | enteField | Motivo |
|---|---|---|---|
| `Dipt00f` | `dtmatr` | `enteap` | Tabella turni |
| `Wstr01lx` | `wtmatr` | `enteap` | Tabella presenze |
| `Wstr02f` | `mnmatr` | `enteap` | Tabella menù |

## Riflessioni DRY + KISS

### Filosofia

Il pattern centralizza la logica di join `matr`/`ente` in `BaseModel::hasManyByEnteMatr()`. Questo elimina la duplicazione e permette override semantici tramite `matrField()` e `enteField()`.

### Zen della Simmetria

Ogni modello "parla" il proprio dialect: `Sto00f` usa `stann`, `Qua00f` usa `quaann`, `Rep00f` usa `repann`. Il trait `EnteMatrRelationship` delega a `$this->annFieldName()` del modello target.

### Evoluzione

1. **Fase 1**: Hardcoded `'matr'`, `'ente'` in ogni modello
2. **Fase 2**: Introduzione `EnteMatrFieldsContract` contract
3. **Fase 3**: Helper `hasManyByEnteMatr()` in `BaseModel`
4. **Fase 4**: Trait condiviso `EnteMatrRelationship`
5. **Fase 5**: Filtro ann automatico via `applyRelatedActiveAnnFilter()`

## Action Items

- [x] Sto00f - usa EnteMatrRelationship
- [x] Creazione Qua00k1Relationship trait
- [x] EnteMatrRelationship - aggiungi filtri ann
- [ ] Audit Employee (Incentivi)
- [ ] Audit Qua00f (qua00f, rep00f)
- [ ] Audit LettF (IndennitaResponsabilita)

## Collegamenti

- [Architecture](./architecture.md)
- [EnteMatrFieldsContract Contract](../Contracts/EnteMatrFieldsContract.php)
- [DateRangeFieldsContract Contract](../Contracts/DateRangeFieldsContract.php)