---
title: "Censimento metodi relazione duplicate"
type: catalog
module: system-wide
tags: [refactoring, duplicate-methods, relationship]
created: 2026-06-15
updated: 2026-06-15
---

# Metodi `qua00f()`, `rep00f()` - Audit relazioni duplicate

## Scopo

Catalogare metodi di relazione con pattern identico: `->where('ente', $this->ente)->whereRaw('...ann=""')`.

## Codice pattern rilevato

```php
$this->hasMany(Qua00f::class, 'matr', 'matr')
    ->where('ente', $this->ente)
    ->whereRaw('quaann=""');
```

## Risultati ricerca

| Modulo | File | Metodo | Linea | Commento |
|--------|------|--------|-------|----------|
| IndennitaResponsabilita | LettF.php | qua00fRetribuzioneDateRange | 371 | Usa ofRangeDate (corretto) |
| IndennitaResponsabilita | LettF.php | rep00fByAnno | 340 | Usa ofYear (corretto) |
| Sigma | Qua00f.php | qua00fsimple | 219 | Base model, nessun filtro |
| Sigma | Qua00f.php | qua00f | 231 | Base model, nessun filtro |
| Sigma | Rep00f.php | rep00f | 255 | Base model |
| Sigma | Asz00k1.php | qua00fsimple | 219 | Con filtro ente/quaann |
| Sigma | Asz00k1.php | qua00f | 231 | Con filtro ente/quaann |

## Reflection

### Pattern DRY violato

Ogni model con ente/matr ripete:
- `where('ente', $this->ente)`
- `whereRaw('xxxann=""')`

### Soluzione proposta

1. **BaseModel** → aggiungere `enteField(): string` e `matrField(): string`
2. **Trait base** → `EnteMatrRelationship` con metodi generici
3. **Override** → solo quando necessario (es. filtri diversi)

## Status

- LettF.php: ✅ Refactoring parziale (qua00fRetribuzioneDateRange ben fatto)
- Altri model: ⏳ Handoff creato in `docs/chat/handoff-matr-ente-field-abstraction.md`