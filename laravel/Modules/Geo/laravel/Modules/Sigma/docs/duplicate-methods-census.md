# Censimento Metodi Duplicati — Modulo Sigma

**Data**: 2026-06-15
**Scope**: `Modules/Sigma/app/Models/`
**Totale metodi con nome identico (≥2 occorrenze)**: 167

---

## Categorie di Duplicazione

### 1. Cloni Trait: SchedaTrait vs SchedaExtraFieldTrait (CRITICO)

| File | Righe | Metodi |
|---|---|---|
| `Traits/SchedaTrait.php` | 2959 | 128 |
| `Traits/SchedaExtraFieldTrait.php` | 2623 | 115 |
| `Traits/Extras/FunctionExtra.php` | 1167 | ~40 |

**Problema**: `SchedaExtraFieldTrait` è un clone quasi identico di `SchedaTrait`.
Nessuno dei due è attualmente usato (`use SchedaTrait` non appare in nessun modello).
`FunctionExtra` è usato da `Asz00k1`, `Qua03f`, `Anag`, `Qua00f`.

**~90 metodi duplicati tra SchedaTrait e SchedaExtraFieldTrait**, tutti accessor `get*Attribute`.

**Riflessione**: Questi file sono legacy morto. `SchedaTrait` (2959 righe) viola ogni regola di qualità. La direzione corretta è:
- Eliminare `SchedaExtraFieldTrait` (clone inutile)
- Spezzare `SchedaTrait` in trait atomici (già iniziato con `SchedaHelper`, `PerfAccessor`)
- Migrare logica residua in `FunctionExtra` o trait dedicati

---

### 2. Contratto/Override (CORRETTI — Design Pattern)

Metodi che appaiono multipli perché definiti nel contratto/base e overriddati nei modelli.

| Metodo | Count | Note |
|---|---|---|
| `rangeFromField()` | 9 | Contratto + override in ogni BaseDateRangeModel |
| `rangeToField()` | 9 | Idem |
| `annFieldName()` | 9 | Idem |
| `casts()` | 8 | Override Laravel standard |
| `matrField()` | 5 | Contratto EnteMatrFieldsContract + override |
| `enteField()` | 5 | Idem |

**Riflessione**: Questi sono corretti. Il polimorfismo per design richiede override. Non sono duplicati da eliminare.

---

### 3. Scope Duplicati nei Modelli (DA UNIFICARE)

| Metodo | Dove | Azione |
|---|---|---|
| `scopeWithDays` | Asz00k1, Asz00f, Rep00f, Qua00f | → Trait `WithDaysScope` o in `CommonScope` |
| `scopeOfYear` | Rep00f, Qua00f, CommonScope | Rep00f e Qua00f override — verificare se eliminabili |
| `scopeOfEnteYear` | Rep00f, Qua00f, CommonScope | Idem |

**Riflessione**: `scopeWithDays` è identico in 4 modelli → deve migrare in `CommonScope` o in un trait dedicato. Gli override di `scopeOfYear`/`scopeOfEnteYear` potrebbero essere necessari se la logica differisce.

---

### 4. Metodi Business Duplicati (DA UNIFICARE)

| Metodo | Count | Dove |
|---|---|---|
| `giorni()` | 4 | Qua03f, Qua00f, Qua00k1, Sto00f |
| `gg()` | 4 | Asz00k1, Qua03f, Qua00f, Sto00f |
| `codici()` | 4 | Asz00k1, Asz00f, Wgiu03f, Mov01k2 |
| `qua00f()` | 3 | Asz00k1, Rep00f, EnteMatrRelationship |
| `wstr01lx()` | 3 | Wstr02f, EnteMatrRelationship, Wmen00f |
| `getNomeAttribute()` | 4 | Ana10f, Dipt00f, Qua00f, EnteMatrMutator |
| `getCognomeAttribute()` | 4 | Ana10f, Dipt00f, Qua00f, EnteMatrMutator |
| `getGgAttribute()` | 6 | Diversi trait Scheda |
| `getCategoriaEcoAttribute()` | 6 | Diversi trait Scheda |
| `getToFieldAttribute()` | 3 | Asz00k1, Qua00f (legacy accessor) |

**Riflessione**:
- `giorni()`/`gg()`: calcolano giorni in range date. Differiscono per i campi usati (`st2kas/st2kdi`, `qua2kd/qua2ka`, `asz2kd/asz2ka`). Candidati per un trait `GiorniCalc` che usa `rangeFromField()`/`rangeToField()`.
- `codici()`: relazione HasOne a `Codici` — può migrare in trait `CodiciRelationship`.
- `getNome/getCognome`: presenti in `EnteMatrMutator` (trait) E in modelli concreti che lo overridano. Verificare se gli override sono necessari.
- `getToFieldAttribute`: legacy accessor (pre-contratto). Da rimuovere ora che esiste `rangeToField()`.

---

### 5. Relazioni Duplicate (DA VERIFICARE)

| Metodo | Dove | Azione |
|---|---|---|
| `qua00f()` | Asz00k1, Rep00f, EnteMatrRelationship | I modelli override perché aggiungono scope specifici |
| `wstr01lx()` | Wstr02f, Wmen00f, EnteMatrRelationship | Wstr02f/Wmen00f hanno FK diverse |
| `anag()` | Diversi | Override per BelongsTo vs HasOne |

**Riflessione**: Le relazioni duplicate nei modelli concreti sono spesso override con logica aggiuntiva (es. `ofRangeDate`). Questi sono legittimi.

---

### 6. PerfInd Year Accessor (PATTERN MECCANICO)

```
getPerfInd2030Attribute ... getPerfInd2014Attribute
```

17 accessor identici che differiscono solo per l'anno. Duplicati tra `SchedaTrait` e `SchedaExtraFieldTrait`.

**Riflessione**: Pattern da generare con metaprogrammazione o un singolo accessor parametrico:
```php
protected function getPerfIndYearAttribute(int $year): ?float { ... }
```

---

## Violazioni residue "ann hardcoded" (17 occorrenze)

Dopo la migrazione a `applyRelatedActiveAnnFilter`, restano 17 `whereRaw('...ann=""')` in:
- `EnteMatrAnnoRelationship` (3) — usa `hasMany` diretto, non `hasManyByEnteMatr`
- `Rep00f` (3) — relazioni locali con scope aggiuntivi
- `EnteStabiMutator` (2), `Wmen00f` (2), `Wstr02f` (2)
- `EnteMatrDateRangeRelationship` (1), `EnteMatrYearRelationship` (1), `TquRelationship` (1)
- `Mov01k2` (1), `Wstr01lx` (1)

**Nota**: `Qua00k1` NON estende `BaseDateRangeModel` (estende solo `BaseModel`) → il filtro ann automatico NON si attiva. Candidato alla migrazione.

---

## Priorità di Intervento

1. **ELIMINARE** `SchedaExtraFieldTrait` (clone morto, 2623 righe)
2. **MIGRARE** `Qua00k1` a `BaseDateRangeModel` (elimina whereRaw hardcoded)
3. **CREARE** trait `WithDaysScope` per `scopeWithDays` (4 modelli)
4. **CREARE** trait `GiorniCalc` per `giorni()`/`gg()` basato su `rangeFromField()`
5. **CREARE** trait `CodiciRelationship` per `codici()` (4 modelli)
6. **RIMUOVERE** `getToFieldAttribute`/`getFromFieldAttribute` (legacy, sostituiti da contratto)
7. **UNIFICARE** `getPerfInd*Attribute` in metodo parametrico
8. **ELIMINARE** tutti i `whereRaw('...ann=""')` residui dopo migrazione modelli a BaseDateRangeModel

---

## Statistiche

- **Metodi unici nel modulo**: ~450
- **Metodi con nome duplicato (≥2)**: 167 nomi, ~400 occorrenze
- **Righe di codice duplicato stimato**: ~4000 (principalmente SchedaTrait/SchedaExtraFieldTrait)
- **Risparmio potenziale**: ~3500 righe eliminabili

---

*Generato automaticamente. Aggiornare dopo ogni refactoring.*
