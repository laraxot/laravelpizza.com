---
title: "HasMany matr/ente Pattern - DRY + KISS"
type: "patterns"
tags: ["dry", "kiss", "relationships", "sigma", "patterns"]
created: "2026-06-15"
updated: "2026-06-15"
---

# HasMany matr/ente Pattern - DRY + KISS

## Sintesi Esecutiva

Pattern centralizzato per relazioni HasMany che uniscono `matricola` + `ente` evita duplicazione in 50+ modelli Sigma.

## Regola Fondamentale

> Ogni modello con `ente`/`matr` deve implementare `matrField()` e `enteField()` e usare `hasManyByEnteMatr()`.

## Architettura

```
BaseModel (implementa EnteMatrFieldsContract)
    ├── matrField() = 'matr' (override opzionale)
    ├── enteField() = 'ente' (override opzionale)
    └── hasManyByEnteMatr(RelatedClass)
            → Usa matrField/enteField
            → Applica filtro annFieldName() automatico

Trait: EnteMatrRelationship
    ├── Usa hasManyByEnteMatr
    ├── Filtri ann vuoti (quaann="", repann="")
    └── Relazioni: qua00f, rep00f, sto00f, asz00k1, ...
```

## Esempi Pratici

### Prima (Hardcoded - ❌)
```php
public function qua00f(): HasMany
{
    return $this->hasMany(Qua00f::class, 'matr', 'matr')
        ->where('ente', $this->ente)
        ->whereRaw('quaann=""');
}
```

### Dopo (DRY - ✅)
```php
public function qua00f(): HasMany
{
    return $this->hasManyByEnteMatr(Qua00f::class)
        ->whereRaw('quaann=""');
}
```

## Override Semantico

| Modello | matrField | enteField | Tabella | Motivo |
|---|---|---|---|---|
| `Sto00f` | `matr` | `ente` | `sto00f` | Campo standard |
| `Dipt00f` | `dtmatr` | `enteap` | `dipt00f` | Campo legacy turni |
| `Wstr01lx` | `wtmatr` | `enteap` | `wstr01lx` | Tabella presenze |

## Action Items

- [x] Sto00f - usa EnteMatrRelationship
- [x] Qua00k1Relationship trait creato
- [ ] Audit LettF, Employee, Qua00f

## Riflessione Zen

Il codice non mentire mai: `matr`/`ente` hardcoded = duplicazione. I contratti e i trait sono preghiere silenziose per la simmetria.