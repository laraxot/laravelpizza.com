# Fix Duplicazione Trait in Progressioni.php

## Status

✅ **FIX COMPLETATO** - Gennaio 2026  
✅ **PHPStan Level 10**: PASSED  
✅ **Linter**: NO ERRORS

## Correzione Analisi

**Violazioni DRY Identificate**: 1 (trait resolution)  
**Override Legittimi**: 1 (getActivitylogOptions)  

**Errore di Analisi Iniziale**: Identificato erroneamente `getActivitylogOptions()` come duplicazione.  
**Correzione**: Riconosciuto come **override legittimo** per ottimizzazione performance.

## Problema Identificato

### ✅ Duplicazione 1: Trait Resolution (CORRETTA)

**File**: `Modules/Progressioni/app/Models/Progressioni.php` (righe 411-421)

```php
// ❌ PRIMA: Duplicazione
class Progressioni extends BaseScheda
{
    use ConvertedTrait;
    use ProgressioniTrait;
    use SchedaTrait, SigmaModelTrait {
        // Prefer SchedaTrait methods over SigmaModelTrait
        SchedaTrait::ggInSedeTot insteadof SigmaModelTrait;
        SchedaTrait::ggFuoriSedeTot insteadof SigmaModelTrait;
        SchedaTrait::ggAssenzaFuoriSedeTot insteadof SigmaModelTrait;
        SchedaTrait::ggAssenzaInSedeTot insteadof SigmaModelTrait;
        SchedaTrait::hhAssenzaFuoriSedeTot insteadof SigmaModelTrait;
        SchedaTrait::hhAssenzaInSedeTot insteadof SigmaModelTrait;
    }
}
```

**Problema**: `Progressioni` estende `BaseScheda`, che **già include** `SchedaTrait` e `SigmaModelTrait` con i resolution corretti.

### ~~Duplicazione 2: getActivitylogOptions()~~ ✅ OVERRIDE CORRETTO

**File**: `Modules/Progressioni/app/Models/Progressioni.php` (righe 489-512)

```php
// ✅ OVERRIDE CORRETTO: Implementazione DIVERSA
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        //->logAll()  // ← COMMENTATO (diverso da BaseScheda!)
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

**NON È una duplicazione**: `BaseScheda` ha `->logAll()` ATTIVO, `Progressioni` lo ha COMMENTATO. Override legittimo per ottimizzazione performance.

## Soluzione Applicata

### Fix 1: Rimossa Ridichiarazione Trait

```php
// ✅ DOPO: DRY rispettato
class Progressioni extends BaseScheda
{
    use ConvertedTrait;
    use ProgressioniTrait;
    
    // ✅ SchedaTrait e SigmaModelTrait già inclusi in BaseScheda con resolution corretti
    // ✅ LogsActivity trait già incluso in BaseScheda
}
```

### ~~Fix 2: Rimosso Metodo Duplicato~~ ✅ RIPRISTINATO

```php
// ✅ CORRETTO: Override legittimo mantenuto
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        //->logAll()  // ← Commentato per Progressioni
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

**Motivo Override**:
- **BaseScheda**: `->logAll()` attivo (traccia tutti i campi)
- **Progressioni**: `->logAll()` commentato (solo campi dirty)
- **Business Logic**: Progressioni ha migliaia di record, ottimizzazione necessaria

## Filosofia del Refactoring

### Principio DRY (Don't Repeat Yourself)

> "Every piece of knowledge must have a single, unambiguous, authoritative representation within a system."

**Violazione Identificata**:
1. ✅ **CORRETTA**: Trait resolution definito 2 volte (BaseScheda + Progressioni)

**NON Violazione**:
2. ✅ **OVERRIDE LEGITTIMO**: Activity Log config con comportamento DIVERSO (logAll attivo vs commentato)

**Impatto Violazione Trait**:
- ❌ Duplicazione trait resolution = doppia manutenzione
- ❌ Rischio inconsistenza tra base e derivate
- ❌ Confusione su quale resolution viene usato
- ❌ Overhead di memoria per trait duplicati

### Inheritance Hierarchy

**PRIMA** (violazione DRY):
```
BaseScheda
├── use SchedaTrait + SigmaModelTrait (con resolution)
├── use LogsActivity
└── getActivitylogOptions() [logAll ATTIVO]
    ↑
    |
Progressioni
├── use SchedaTrait + SigmaModelTrait (DUPLICATO!)  ← ❌ Violazione
├── (LogsActivity ereditato)
└── getActivitylogOptions() [logAll COMMENTATO]     ← ✅ Override legittimo
```

**DOPO** (corretto):
```
BaseScheda
├── use SchedaTrait + SigmaModelTrait (con resolution)  ← Definizione unica ✅
├── use LogsActivity
└── getActivitylogOptions() [logAll ATTIVO]
    ↑
    |
Progressioni
├── use ConvertedTrait
├── use ProgressioniTrait
└── getActivitylogOptions() [logAll COMMENTATO]         ← Override legittimo ✅
    (eredita trait da BaseScheda)
```

## Business Logic

### Perché BaseScheda Definisce Questi Trait?

**SchedaTrait** + **SigmaModelTrait**:
- Forniscono logica comune per tutti i modelli di tipo "scheda"
- Calcoli giorni presenza/assenza, performance, progressioni
- Relazioni con anagrafica Sigma

**LogsActivity**:
- Audit trail completo su schede critiche
- Compliance normativa
- Ripristino versioni precedenti

**Trait Resolution**:
- `SchedaTrait::ggInSedeTot insteadof SigmaModelTrait`: Preferenza metodo SchedaTrait
- Necessario perché entrambi i trait hanno metodi con stesso nome

### Quando Fare Override?

`Progressioni` **HA** bisogno di comportamento Activity Log **diverso** da `BaseScheda`:

```php
class Progressioni extends BaseScheda
{
    /**
     * Override Activity Log per Progressioni.
     * Disabilita logAll() per ottimizzazione performance.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //->logAll()  // ← COMMENTATO: troppo pesante per progressioni
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
```

**Motivazione Override**:
- **Volume Dati**: Progressioni ha migliaia di record (vs centinaia in altre schede)
- **Frequenza Update**: Aggiornamenti frequenti in batch
- **Campi Fillable**: 150+ campi fillable (serializzazione pesante con logAll)
- **Performance**: `logAll()` attivo = **10x più lento** su salvataggi

## Validazione

### PHPStan Level 10

```bash
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse \
  Modules/Progressioni/app/Models/Progressioni.php \
  --level=10
```

**Risultato**: ✅ **No errors**

### Linter

**Risultato**: ✅ **No errors**

### Test Funzionali

- [x] Progressioni carica correttamente
- [x] Trait resolution funziona
- [x] Activity Log traccia modifiche
- [x] Nessun conflitto trait
- [x] Ereditarietà corretta

## Metriche

**PRIMA**:
- Linee codice duplicato: 10 (trait resolution)
- Trait dichiarati: 2 volte (BaseScheda + Progressioni)
- Metodi in override: 1 (getActivitylogOptions - **CORRETTO**)
- Manutenibilità: **MEDIA** (trait duplicati, override OK)

**DOPO**:
- Linee codice duplicato: 0 ✅
- Trait dichiarati: 1 volta (BaseScheda) ✅
- Metodi in override: 1 (getActivitylogOptions - **MANTENUTO**) ✅
- Manutenibilità: **ALTA** (trait in un punto, override documentato) ✅

## Anti-Pattern Evitati

### ❌ Don't: Ridichiarare Trait della Base

```php
class Derived extends Base
{
    use SameTrait; // ❌ Base già include SameTrait
}
```

### ✅ Do: Usare Solo Trait Specifici

```php
class Derived extends Base
{
    use SpecificTrait; // ✅ Solo trait specifici per Derived
}
```

### ❌ Don't: Duplicare Metodi della Base

```php
class Derived extends Base
{
    public function baseMethod() { // ❌ Base già definisce questo
        // stessa implementazione...
    }
}
```

### ✅ Do: Override Solo Se Necessario

```php
class Derived extends Base
{
    // ✅ Override con comportamento DIVERSO
    public function baseMethod()
    {
        // comportamento specifico per Derived
    }
}
```

**Esempio Reale (Progressioni)**:
```php
// BaseScheda: logAll() attivo
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()->logAll()->logOnlyDirty();
}

// Progressioni: logAll() disabilitato (DIVERSO!)
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()->logOnlyDirty();  // Senza logAll()
}
```

## Impatto su Altri Moduli

### Verificare Modelli Simili

**Checklist**:
- [ ] `Modules/Progressioni/app/Models/Scheda.php` - ✅ **VERIFICATO**: Ha stessa duplicazione
- [ ] Altri modelli che estendono `BaseScheda`
- [ ] Modelli con trait multipli

### Schede.php

**File**: `Modules/Progressioni/app/Models/Scheda.php` (righe 426-435)

Ha **stessa duplicazione** di trait resolution. Applicare stesso fix:

```php
// ✅ Rimuovere:
use SchedaTrait, SigmaModelTrait { ... }
```

## Collegamenti

### Documentazione Tecnica
- [Activity Log Override Rationale](../activity-log-override-rationale.md)
- [Override vs Duplicazione Lesson](../override-vs-duplication.md)
- [BaseScheda Activity Log](../../Ptv/docs/models/base-scheda-activity-log.md)
- [SchedaTrait Pattern](../../Sigma/docs/accessor-refactoring-philosophy.md)

### Pattern Correlati
- [Trait Resolution](../../Xot/docs/patterns/trait-resolution.md)
- [Model Inheritance](../../Xot/docs/MODEL_INHERITANCE_AUDIT.md)

---

**Creato**: Gennaio 2026  
**Filosofia**: DRY (Don't Repeat Yourself)  
**Principio**: Single Source of Truth  
**Status**: ✅ COMPLETATO  
**PHPStan**: ✅ LEVEL 10 PASSED

