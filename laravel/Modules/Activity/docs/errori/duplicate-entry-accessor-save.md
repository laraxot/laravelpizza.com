# Errore: Duplicate Entry Durante Activity Log

## Problema

```
SQLSTATE[23000]: Integrity constraint violation: 1062 
Duplicate entry '9075' for key 'indennita_responsabilita.PRIMARY'
```

**Quando**: Durante il salvataggio di una modifica in Filament EditRecord  
**Trigger**: Spatie Activity Log cerca di serializzare le properties  
**Causa**: Accessor che chiamano `$this->save()` al loro interno

## Business Logic

### Scenario Utente

Un amministratore modifica un record IndennitaResponsabilita esistente (ID 9075):
1. Apre `/indennita-responsabilitas/9075/edit`
2. Modifica un campo (es. `stabi` o `coordinamento`)
3. Clicca "Salva"
4. ❌ **ERRORE**: Duplicate entry

### Cosa Succede Sotto il Cofano

```
EditRecord::save()
 └─> $record->save()
      └─> Event: updating
           └─> LogsActivity::updated()  ← Activity Log
                └─> $activity->properties = $record->toArray()
                     └─> Accede a TUTTI gli accessor
                          └─> getProproAttribute()
                               └─> $this->save()  ← PROBLEMA!
                                    └─> INSERT invece di UPDATE
                                         └─> 💥 Duplicate Entry!
```

## Stack Trace Chiave

```
9  - Modules/Sigma/app/Models/Traits/SchedaTrait.php:617
     public function getProproAttribute(?int $value): ?int
     {
         if ($value != null) {
             return $value;
         }
         $this->propro = $this->getPropro();
         $this->save();  ← CHIAMATO DA ACCESSOR!
         return $value;
     }

14 - vendor/spatie/laravel-activitylog/src/Traits/LogsActivity.php:354
     // Activity Log cerca di serializzare il modello
     $properties = $model->toArray();  ← Accede a tutti gli accessor!

24 - vendor/filament/filament/src/Resources/Pages/EditRecord.php:272
     // Save del record che triggera Activity Log
```

## Causa Radice

### Anti-Pattern: `$this->save()` negli Accessor

**SchedaTrait** ha numerosi accessor che chiamano `$this->save()`:

```php
// ❌ ANTI-PATTERN CRITICO
public function getProproAttribute(?int $value): ?int
{
    if ($value != null) {
        return $value;
    }

    $this->propro = $this->getPropro();
    $this->save();  // ← MAI fare questo in un accessor!

    return $value;
}

public function getGgAttribute(?int $_value): ?int
{
    // ... calcolo ...
    $this->gg = $value;
    $this->save();  // ← MAI fare questo in un accessor!
    
    return $value;
}

public function getValutatoreIdAttribute(?int $value): ?int
{
    // ... logica ...
    $this->valutatore_id = $valutatore_id;
    $this->save();  // ← MAI fare questo in un accessor!
    
    return $value;
}

// E MOLTI ALTRI...
```

### Perché è un Problema con Activity Log?

1. **Activity Log serializza il modello**:
   ```php
   // LogsActivity::updated()
   $properties = $model->toArray();  // Accede a TUTTI gli attributi
   ```

2. **toArray() accede agli accessor**:
   ```php
   // Laravel chiama gli accessor per ogni attributo
   $propro = $model->propro;  // Chiama getProproAttribute()
   ```

3. **Accessor chiama save()**:
   ```php
   public function getProproAttribute(?int $value): ?int
   {
       $this->save();  // ← Salva il modello DURANTE la lettura!
   }
   ```

4. **Save durante save = caos**:
   - Il modello è già in uno stato "saving"
   - `$model->exists` potrebbe non essere corretto
   - Laravel potrebbe fare INSERT invece di UPDATE
   - Se fa INSERT con stessa PK → Duplicate Entry!

## Soluzioni

### Soluzione 1: Disabilitare Activity Log per SchedaTrait (TEMPORANEA)

```php
// Modules/Ptv/app/Models/BaseScheda.php

/**
 * ⚠️ TEMPORANEAMENTE DISABILITATO
 * 
 * Activity Log causa errori "Duplicate Entry" perché SchedaTrait
 * ha accessor che chiamano $this->save() al loro interno.
 * 
 * Riabilitare SOLO dopo aver corretto tutti gli accessor in SchedaTrait.
 * 
 * @see \Modules\Activity\docs\errori\duplicate-entry-accessor-save.md
 */
// use LogsActivity;  // ← COMMENTATO

public function getActivitylogOptions(): LogOptions
{
    // Configurazione... MA IL TRAIT È DISABILITATO!
}
```

### Soluzione 2: Rimuovere `$this->save()` dagli Accessor (CORRETTA)

#### ✅ Pattern Corretto: Accessor Senza Side Effects

```php
// ✅ CORRETTO
public function getProproAttribute(?int $value): ?int
{
    if ($value != null) {
        return $value;
    }

    // Calcola il valore ma NON salvare!
    return $this->calculatePropro();
}

// Salva esplicitamente quando necessario
public function updatePropro(): void
{
    $this->propro = $this->calculatePropro();
    $this->save();
}
```

#### Pattern Lazy Loading

Se vuoi calcolare e cachare il valore al primo accesso:

```php
public function getProproAttribute(?int $value): ?int
{
    // Se esiste nel DB, usalo
    if ($value != null) {
        return $value;
    }

    // Calcola ma non salvare automaticamente
    $calculated = $this->calculatePropro();
    
    // Cachea in memoria per questa request
    $this->attributes['propro'] = $calculated;
    
    return $calculated;
}

// Salva manualmente quando vuoi persistere
$scheda->propro;  // Calcola
$scheda->save();  // Persiste
```

### Soluzione 3: Usare `$appends` Invece di Accessor con Save

```php
class BaseScheda extends BaseModel
{
    /**
     * Attributi calcolati da appendere al modello.
     * Non interferiscono con Activity Log perché non sono salvati nel DB.
     */
    protected $appends = [
        'propro_calculated',
        'gg_calculated',
    ];
    
    /**
     * Accessor senza side effects.
     */
    public function getProproCalculatedAttribute(): ?int
    {
        return $this->calculatePropro();
    }
}
```

### Soluzione 4: Escludere Attributi Problematici da Activity Log

```php
// Modules/Ptv/app/Models/BaseScheda.php

public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logAll()
        ->logExcept([
            // Escludi attributi con accessor che causano problemi
            'propro',
            'gg',
            'gg_asz',
            'gg_no_asz',
            'valutatore_id',
            'perf_ind_media',
            'punt_progressione_finale',
            // ... altri attributi problematici ...
        ])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

## Fix Immediato (Temporaneo)

Per risolvere l'errore SUBITO senza refactoring massiccio:

```php
// Modules/Ptv/app/Models/BaseScheda.php

abstract class BaseScheda extends BaseModel
{
    // COMMENTARE questo trait temporaneamente
    // use LogsActivity;
    
    /**
     * Activity Log disabilitato temporaneamente.
     * 
     * Causa: SchedaTrait ha accessor con $this->save() che causano
     *        errori "Duplicate Entry" durante serializzazione Activity Log.
     * 
     * TODO: Riabilitare dopo aver corretto SchedaTrait accessor.
     * 
     * @see \Modules\Activity\docs\errori\duplicate-entry-accessor-save.md
     */
}
```

## Fix Definitivo (Refactoring)

### Fase 1: Audit Completo

```bash
cd /var/www/html/ptvx/laravel
grep -n "\$this->save()" Modules/Sigma/app/Models/Traits/SchedaTrait.php
```

**Risultato**: 15+ accessor che chiamano `$this->save()`

### Fase 2: Refactoring Sistematico

Per OGNI accessor che fa `$this->save()`:

1. **Rimuovi `$this->save()`**
2. **Crea metodo separato** per update persistente
3. **Aggiorna chiamate** per usare il nuovo metodo
4. **Test regressione**

Esempio:

```php
// PRIMA
public function getProproAttribute(?int $value): ?int
{
    if ($value != null) {
        return $value;
    }
    $this->propro = $this->getPropro();
    $this->save();  // ← RIMUOVI
    return $value;
}

// DOPO
public function getProproAttribute(?int $value): ?int
{
    if ($value != null) {
        return $value;
    }
    
    // Calcola e cacha in memoria
    $calculated = $this->calculateProproValue();
    $this->attributes['propro'] = $calculated;
    
    return $calculated;
}

protected function calculateProproValue(): ?int
{
    // Logica di calcolo estratta
    return $this->getPropro();
}

public function persistPropro(): void
{
    $this->propro = $this->calculateProproValue();
    $this->save();
}
```

### Fase 3: Testing

```php
// tests/Feature/Models/SchedaTrait/AccessorWithoutSaveTest.php

test('accessor calculates value without saving', function () {
    $scheda = IndennitaResponsabilita::factory()->create(['propro' => null]);
    
    // Prima del fix: questo causava save
    // Dopo il fix: calcola ma non salva
    $propro = $scheda->propro;
    
    $scheda->refresh();
    expect($scheda->getAttributes()['propro'])->toBeNull('Accessor non deve salvare automaticamente');
});

test('persist method saves calculated value', function () {
    $scheda = IndennitaResponsabilita::factory()->create(['propro' => null]);
    
    // Salva esplicitamente
    $scheda->persistPropro();
    
    $scheda->refresh();
    expect($scheda->propro)->not->toBeNull('Persist deve salvare il valore');
});
```

## Priorità Interventi

### 🔴 URGENTE (Blocca produzione)

1. Disabilitare temporaneamente Activity Log su BaseScheda
2. Deploy immediato
3. Verificare che edit funzioni

### 🟡 ALTA (Settimana corrente)

4. Audit completo accessor in SchedaTrait
5. Identificare tutti accessor che chiamano `->save()`
6. Creare issue/task per refactoring

### 🟢 MEDIA (Sprint successivo)

7. Refactoring sistematico accessor
8. Test regressione completi
9. Riabilitare Activity Log
10. Monitoraggio produzione

## Pattern Anti-Pattern

### ❌ NON FARE MAI

```php
// Accessor con side effects
public function getSomethingAttribute($value)
{
    $this->something = $this->calculate();
    $this->save();  // ← MAI!
    return $value;
}

// Mutator con query pesanti
public function setSomethingAttribute($value)
{
    $this->heavyCalculation();  // ← EVITARE
    $this->attributes['something'] = $value;
}
```

### ✅ SEMPRE FARE

```php
// Accessor senza side effects
public function getSomethingAttribute($value)
{
    if ($value !== null) {
        return $value;
    }
    
    // Calcola e cacha in memoria
    $calculated = $this->calculate();
    $this->attributes['something'] = $calculated;
    
    return $calculated;
}

// Metodi espliciti per persistenza
public function updateSomething(): void
{
    $this->something = $this->calculate();
    $this->save();
}

// Observers per logica automatica
class SchedaObserver
{
    public function saving(BaseScheda $scheda): void
    {
        if ($scheda->propro === null) {
            $scheda->propro = $scheda->calculateProproValue();
        }
    }
}
```

## Risorse

### Documentazione Laravel
- [Eloquent Accessors](https://laravel.com/docs/eloquent-mutators#accessors-and-mutators)
- [Model Events](https://laravel.com/docs/eloquent#events)

### Documentazione Interna
- [Activity Module - README](../README.md)
- [BaseScheda Activity Log](../../Ptv/docs/models/base-scheda-activity-log.md)
- [SchedaTrait Refactoring Plan](../../Sigma/docs/refactoring/scheda-trait-accessors.md)

### Issue Tracker
- [GitHub Issue #XXX: Refactor SchedaTrait Accessor with $this->save()](link)
- [Jira PTCL-XXX: Remove save() from SchedaTrait accessors](link)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Severità**: CRITICA (blocca edit in produzione)  
**Workaround**: Disabilitare temporaneamente LogsActivity trait  
**Fix Definitivo**: Refactoring accessor in SchedaTrait  
**Impatto**: Tutti i modelli che usano BaseScheda (IndennitaResponsabilita, Progressioni, etc.)


