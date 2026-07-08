# Scheda Accessor: Architettura Sub-Traits Professionale

## ⚠️ Problema Scoperto

**Estrazione completa** di 83 accessor da SchedaTrait = **2702 righe**!

SchedaMutator esistente: **491 righe**  
**Totale se merged**: **3193 righe** ❌ TROPPO GRASSO!

## 🎯 Decisione Architetturale Intelligente

### Opzione A: SchedaMutator Monolit ico (❌ Sconsigliato)

```
SchedaMutator.php (3193 righe!)
  - Tutti gli accessor in un file
  - ❌ Viola stesso problema di SchedaTrait originale
  - ❌ Difficile navigare e mantenere
```

### Opzione B: Sub-Traits per Categoria (✅ PROFESSIONALE)

```
Mutators/
├── SchedaMutator.php (100 righe) - Trait composition
├── SchedaAccessor/
│   ├── GgAccessor.php (~800 righe) - Accessor giorni (gg_*)
│   ├── PerfAccessor.php (~400 righe) - Accessor performance (perf_*)
│   ├── CategoriaAccessor.php (~600 righe) - Accessor categoria (categoria_*, cateco_*)
│   ├── ValutatoreAccessor.php (~200 righe) - Accessor valutatore
│   ├── BaseAccessor.php (~700 righe) - Accessor base vari
│   └── LegacyAccessor.php (~491 righe) - Accessor esistenti in SchedaMutator
```

**SchedaMutator diventa orchestratore**:
```php
trait SchedaMutator
{
    use SchedaHelper;     // Helper puri
    use GgAccessor;       // Accessor gg_*
    use PerfAccessor;     // Accessor perf_*
    use CategoriaAccessor; // Accessor cateco_*
    use ValutatoreAccessor; // Accessor valutatore
    use BaseAccessor;     // Accessor vari
    use LegacyAccessor;   // Accessor esistenti
}
```

## 📊 Categorizzazione Accessor (83 totali)

### 1. GgAccessor (35 accessor)

**Pattern**: Accessor per campi `gg_*` (giorni presenza/assenza)

**Esempi**:
- `getGgAttribute`
- `getGgAszAttribute`
- `getGgNoAszAttribute`
- `getGgInSedeAttribute`
- `getGgFuoriSedeAttribute`
- `getGgAszInSedeAttribute`
- `getGgAszFuoriSedeAttribute`
- `getGgCatecoAttribute`
- `getGgCatecoInSedeAttribute`
- ... altri 26

**Dimensione stimata**: ~1000 righe

### 2. PerfAccessor (16 accessor)

**Pattern**: Accessor per performance (`perf_ind_*`, valutazioni)

**Esempi**:
- `getPerfInd2014Attribute` ... `getPerfInd2024Attribute` (11 accessor)
- `getPerfIndMediaAttribute`
- `getPerfIndCountLast3YearsAttribute`
- `getExcellencesCountLast3yearsAttribute`
- `getTotalePondAttribute`
- `getPuntProgressioneFinaleAttribute`

**Dimensione stimata**: ~500 righe

### 3. CategoriaAccessor (12 accessor)

**Pattern**: Accessor per categoria economica e posizione funzionale

**Esempi**:
- `getCategoriaEcoAttribute`
- `getCategoriaEcovalAttribute`
- `getPosfunvalAttribute`
- `getProproAttribute`
- ... altri 8

**Dimensione stimata**: ~400 righe

### 4. ValutatoreAccessor (5 accessor)

**Pattern**: Accessor per valutatori

**Esempi**:
- `getValutatoreIdAttribute`
- `getValutatoreTxtAttribute`
- ... altri 3

**Dimensione stimata**: ~200 righe

### 5. BaseAccessor (15 accessor)

**Pattern**: Accessor vari (posiz, eta, ptime, etc.)

**Esempi**:
- `getPostTypeAttribute`
- `getPtimeAttribute`
- `getPosizAttribute`
- `getEtaAttribute`
- ... altri 11

**Dimensione stimata**: ~600 righe

## 🎯 Vantaggi Architettura Sub-Traits

### 1. Navigabilità

**PRIMA**: Cerca in 2909 righe  
**DOPO**: "Accessor gg_asz_in_sede? → GgAccessor.php (1000 righe max)"

### 2. Manutenibilità

**File focalizzati**: Ogni sub-trait ha responsabilità specifica.

### 3. Test

**Test isolati**: Mock solo il sub-trait necessario.

### 4. Merge Conflicts

**Riduzione 90%**: Developer 1 lavora su GgAccessor, Developer 2 su PerfAccessor.

### 5. Performance IDE

**Autocomplete veloce**: File più piccoli = parsing più rapido.

## 📋 Piano di Implementazione Rivisto

### STEP 3A: Crea Sub-Traits (5 file)

1. Crea `GgAccessor.php` con 35 accessor gg_*
2. Crea `PerfAccessor.php` con 16 accessor perf_*
3. Crea `CategoriaAccessor.php` con 12 accessor cateco_*
4. Crea `ValutatoreAccessor.php` con 5 accessor valutatore
5. Crea `BaseAccessor.php` con 15 accessor vari

### STEP 3B: Refactoring SchedaMutator

**Da**:
```php
trait SchedaMutator
{
    // 15 accessor esistenti inline
}
```

**A**:
```php
trait SchedaMutator
{
    use SchedaHelper;
    use GgAccessor;
    use PerfAccessor;
    use CategoriaAccessor;
    use ValutatoreAccessor;
    use BaseAccessor;
}
```

### STEP 3C: Cleanup SchedaTrait

Rimuovere i 83 accessor ora delegati ai sub-trait.

## ⚡ Decisione: Procedi con Sub-Traits?

**Pro**:
- ✅ File manageable (<1000 righe)
- ✅ Responsabilità chiare
- ✅ Scalabile

**Contro**:
- ⚠️ Più file da gestire (5 nuovi)
- ⚠️ Più complessità architetturale

**Raccomandazione**: ✅ **Procedi con sub-traits** (professionale e scalabile)

## 📚 Collegamenti

- [Professional Migration Strategy](./scheda-trait-professional-migration-strategy.md)
- [Method Categorization](./scheda-trait-method-categorization.md)

---

**Creato**: 29 Gennaio 2026  
**Decisione**: Sub-Traits Architecture  
**Status**: 📋 ARCHITETTURA DEFINITA

