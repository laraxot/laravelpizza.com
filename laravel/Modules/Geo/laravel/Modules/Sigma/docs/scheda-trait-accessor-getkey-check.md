# SchedaTrait - Check `getKey() == null` negli Accessor

## Business Logic

### Problema

Gli accessor in `SchedaTrait` che chiamano `$this->save()` possono causare errori quando:
1. **Tentano di salvare un record non ancora persistito** (non ha primary key)
2. **Vengono chiamati durante serializzazione Activity Log** su record già salvato ma in stato inconsistente

### Soluzione: Check `getKey() == null`

```php
public function getProproAttribute(?int $value): ?int
{
    if ($value != null) {
        return $value;
    }
    
    // ✅ FONDAMENTALE: Verifica che il record esista nel database
    if ($this->getKey() == null) {
        return null;
    }
    
    $this->propro = $this->getPropro();
    $this->save();
    
    return $value;
}
```

## Perché `getKey() == null`?

### Cosa Ritorna `getKey()`

- `Model::getKey()` ritorna il valore della **primary key** del modello
- Se `null` → record **non ancora salvato** nel database (`INSERT` non ancora eseguito)
- Se non `null` → record **esiste** nel database (ha un ID)

### Scenario Errore 1: Record Non Persistito

```php
// Crea nuovo record
$scheda = new IndennitaResponsabilita();
$scheda->matr = 12345;

// ❌ ERRORE: Accessor accede a campo calcolato PRIMA di save()
$propro = $scheda->propro;
// → getProproAttribute() viene chiamato
// → $this->getKey() è NULL (record non esiste)
// → $this->save() su record senza PK
// → Comportamento inconsistente o errore
```

**Con il check**:
```php
$propro = $scheda->propro;
// → if ($this->getKey() == null) return null;
// → ✅ Ritorna null senza errori
```

### Scenario Errore 2: Activity Log Serializzazione

```php
// Edit record esistente
$scheda = IndennitaResponsabilita::find(1);
$scheda->stabi = 999;
$scheda->save();
// → Activity Log fa $scheda->toArray()
//   → Accede a TUTTI gli accessor
//     → getProproAttribute()
//       → $this->getKey() NON è null (record esiste)
//       → MA siamo in stato "saving"
//       → ❌ $this->save() causa problemi
```

**Il check `getKey() == null` NON previene questo scenario!**

Per questo usiamo anche `->logExcept()` in BaseScheda per escludere questi campi da Activity Log.

## Scopo del Check

### ✅ Previene

1. **Save su record non persistito**:
   ```php
   $new = new Scheda();
   $new->propro; // Ritorna null senza tentare save
   ```

2. **Errori su calcoli campi prima del primo save**:
   ```php
   $new = new Scheda();
   $new->matr = 123;
   $new->gg; // Ritorna null invece di crashare
   ```

3. **Inconsistenze database**:
   - Non tenta INSERT quando dovrebbe essere UPDATE
   - Non tenta UPDATE su record che non esiste

### ❌ NON Previene (da solo)

1. **Problemi Activity Log**: Il check passa perché il record esiste
2. **Race conditions**: Due accessor che salvano contemporaneamente
3. **Performance**: Save multipli rallentano comunque l'applicazione

### Soluzione Completa

1. **Check `getKey() == null`**: Per record non persistiti
2. **`->logExcept()`** in BaseScheda: Per escludere da Activity Log
3. **Refactoring futuro**: Rimuovere `$this->save()` dagli accessor (best practice)

## Pattern Corretto

### Template Accessor con Save

```php
/**
 * Accessor per campo calcolato che viene salvato nel database.
 * 
 * IMPORTANTE: Il save() è un ANTI-PATTERN ma necessario per legacy code.
 *             Futuro: rimuovere save() e usare Observer pattern.
 * 
 * @param mixed $value Valore corrente dal database
 * @return mixed Valore calcolato
 */
public function getSomeFieldAttribute(mixed $value): mixed
{
    // 1. Se valore già presente, ritornalo
    if ($value !== null && ! request()->input('refresh', 0)) {
        return $value;
    }
    
    // 2. ✅ CHECK FONDAMENTALE: Record deve esistere
    if ($this->getKey() == null) {
        return null;
    }
    
    // 3. Verifica dipendenze necessarie
    if ($this->requiredField == null) {
        return null;
    }
    
    // 4. Calcola valore
    $calculated = $this->calculateSomeField();
    
    // 5. Salva nel database
    $this->some_field = $calculated;
    $this->save();
    
    // 6. Ritorna valore calcolato
    return $calculated;
}
```

### Check già presenti (da mantenere)

✅ Accessor già corretti in SchedaTrait:
- `getPostTypeAttribute()` - linea 176
- `getPosfunvalAttribute()` - linea 193
- `getProproAttribute()` - linea 661
- `getGgAszAttribute()` - linea 260
- `getHhAszAttribute()` - linea 331

### Check mancanti (da aggiungere)

❌ Accessor da correggere in SchedaTrait:
- `getGgAttribute()` - linea 247
- `getGgNoAszAttribute()` - linea 286
- `getGgFuoriSedeNoAszAttribute()` - linea 321
- `getValoreDifferenzialeRapportatoPtAttribute()` - linea 1284
- `getPuntProgressioneFinaleAttribute()` - linea 1442
- `getValutatoreIdAttribute()` - linea 1470, 1489
- `getPerfIndMediaAttribute()` - linea 1949
- `getPerfIndCountLast3YearsAttribute()` - linea 1969

❌ Accessor da correggere in SchedaMutator:
- `getCodquaAttribute()` - linea 57
- `getContAttribute()` - linea 83, 95
- `getTipcoAttribute()` - linea 117
- `getPosizioneEcoAttribute()` - linea 160

## Implementazione Sistematica

### Fase 1: Audit Completo

```bash
cd laravel
# Trova tutti accessor con save()
grep -n "save()" Modules/Sigma/app/Models/Traits/SchedaTrait.php | grep -B10 "Attribute"
```

### Fase 2: Aggiunta Check

Per OGNI accessor trovato, verificare:
1. Ha già `if ($this->getKey() == null) return null;`?
2. Se NO, aggiungerlo **SUBITO** dopo i check iniziali

### Fase 3: Validazione

```bash
# PHPStan
./vendor/bin/phpstan analyze Modules/Sigma/app/Models/Traits --level=9

# PHPMD
./vendor/bin/phpmd Modules/Sigma/app/Models/Traits text cleancode,codesize,controversial,design,naming,unusedcode

# PHPInsights
php artisan insights Modules/Sigma
```

### Fase 4: Test

```php
// Test accessor su record non persistito
test('accessor returns null on non-persisted record', function () {
    $scheda = new IndennitaResponsabilita();
    $scheda->matr = 12345;
    
    // ✅ Non deve causare errori
    expect($scheda->propro)->toBeNull();
    expect($scheda->gg)->toBeNull();
});

// Test accessor su record esistente
test('accessor calculates and saves on existing record', function () {
    $scheda = IndennitaResponsabilita::factory()->create(['propro' => null]);
    
    // ✅ Deve calcolare e salvare
    $propro = $scheda->propro;
    
    $scheda->refresh();
    expect($scheda->getAttributes()['propro'])->not->toBeNull();
});
```

## Performance Impact

### Prima del Fix

```php
$new = new Scheda();
$new->matr = 123;
$new->propro;  // ❌ Tenta save(), errore o comportamento inconsistente
$new->gg;      // ❌ Tenta save(), errore o comportamento inconsistente
```

**Problemi**:
- Errori PHP su save di record non persistito
- Log errors riempiti
- Inconsistenze database

### Dopo il Fix

```php
$new = new Scheda();
$new->matr = 123;
$new->propro;  // ✅ Return null immediatamente
$new->gg;      // ✅ Return null immediatamente
```

**Vantaggi**:
- Nessun errore
- Performance migliorate (no save inutili)
- Comportamento prevedibile

## Best Practice Future

### Pattern Raccomandato: Observer

```php
// Modules/Sigma/app/Observers/SchedaObserver.php

class SchedaObserver
{
    /**
     * Handle before saving a Scheda.
     * Calcola campi derivati se null.
     */
    public function saving(BaseScheda $scheda): void
    {
        // Solo se record GIÀ esiste
        if ($scheda->getKey() === null) {
            return;
        }
        
        // Calcola propro se null
        if ($scheda->propro === null && $scheda->qua2kd !== null) {
            $scheda->propro = $scheda->calculateProproValue();
        }
        
        // Calcola gg se null
        if ($scheda->gg === null && $scheda->gg_in_sede !== null) {
            $scheda->gg = $scheda->gg_in_sede + $scheda->gg_fuori_sede;
        }
        
        // ... altri campi ...
    }
}
```

**Vantaggi**:
- ✅ Nessun `$this->save()` negli accessor
- ✅ Calcoli eseguiti una sola volta durante save
- ✅ Activity Log funziona senza problemi
- ✅ Performance ottimali

## Collegamenti

### Documentazione Correlata
- [Activity Log - Duplicate Entry Error](../../Activity/docs/errori/duplicate-entry-accessor-save.md)
- [BaseScheda - Activity Log Configuration](../../Ptv/docs/models/base-scheda-activity-log.md)
- [SchedaTrait Refactoring Plan](./refactoring/scheda-trait-accessor-save-issue.md)

### Issue Tracker
- [GitHub Issue: Add getKey() check to SchedaTrait accessor](link)
- [Jira PTCL-XXX: Systematic fix for accessor with save()](link)

---

**Created**: 27 Ottobre 2025  
**Status**: IN PROGRESS  
**Priority**: P1 (previene errori su record non persistiti)  
**ETA**: 1 giorno (fix sistematico)  
**Assignee**: TBD


