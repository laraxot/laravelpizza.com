# Pattern Corretto per Accessor con Persistenza

## Business Logic

### Scopo degli Accessor con Save

**Perché esistono accessor che salvano?**

Nel modulo Sigma, molti campi sono **valori derivati calcolati** che:
1. **Dipendono da altri dati** (relazioni, configurazioni)
2. **Sono costosi da calcolare** (query complesse, aggregazioni)
3. **Devono essere persistiti** per performance e storicizzazione
4. **Vengono ricalcolati solo su richiesta** (`?refresh=1`)

**Esempi Business:**
- `gg_cateco_posfun_no_asz`: Giorni categoria/posizione senza assenze
- `gg_esperienza_no_asz`: Giorni esperienza effettiva
- `propro`: Profilo professionale derivato da QUA00F
- `punt_progressione_finale`: Punteggio finale progressione

### Pattern ERRATO (Fix Precedente)

```php
public function getGgCatecoPosfunNoAszAttribute(?int $value): ?int
{
    if ($value != null && ! request()->input('refresh', 0)) {
        return $value;
    }
    if ($this->getKey() == null) {
        return null;
    }

    $value = $this->getGgCatecoPosfunNoAsz();
    
    // ❌ ERRATO: Setta attributo ma NON salva
    $this->attributes['gg_cateco_posfun_no_asz'] = $value;
    // ⚠️ REMOVED: save() in accessor causes infinite loop (anti-pattern)
    
    return $value;
}
```

**Problema:**
- Il valore viene calcolato
- Viene settato in `$this->attributes[]`
- Ma **NON viene salvato nel database**
- Alla prossima lettura, il valore è `null` e viene ricalcolato di nuovo
- **Performance degradate** e **perdita di dati calcolati**

### Pattern CORRETTO

```php
public function getGgCatecoPosfunNoAszAttribute(?int $value): ?int
{
    // 1. Se valore già presente e non richiesto refresh, ritorna cached
    if ($value != null && ! request()->input('refresh', 0)) {
        return $value;
    }
    
    // 2. ✅ CHECK FONDAMENTALE: Record deve esistere prima di salvare
    if ($this->getKey() == null) {
        return null;
    }

    // 3. Verifica dipendenze necessarie
    if ($this->matr == null) {
        return null;
    }
    if ($this->propro == null) {
        return null;
    }

    // 4. Calcola valore
    $value = $this->getGgCatecoPosfunNoAsz();
    
    // 5. Setta attributo
    $this->attributes['gg_cateco_posfun_no_asz'] = $value;
    
    // 6. ✅ SALVA: Il record esiste (getKey() != null), quindi possiamo salvare
    $this->save();
    
    return $value;
}
```

**Perché funziona:**
1. **Check `getKey() == null`** previene save su record non esistenti
2. **`$this->save()`** persiste il valore calcolato
3. **Cache naturale**: alla prossima lettura, `$value != null` ritorna subito
4. **Refresh esplicito**: `?refresh=1` forza ricalcolo

## Differenza con Anti-Pattern

### Anti-Pattern Originale (Causa Loop Infiniti)

```php
public function getGgAnnoAttribute(?int $value): ?int
{
    $value = $this->gg_presenza_anno - $this->gg_assenza_anno;
    $this->save(); // ❌ LOOP INFINITO: save() chiama accessor, che chiama save()...
    return $value;
}
```

**Problema:**
- `save()` triggera `performUpdate()`
- `performUpdate()` legge tutti gli attributi (incluso `gg_anno`)
- Leggere `gg_anno` chiama `getGgAnnoAttribute()`
- Che chiama di nuovo `save()`
- **Loop infinito** ♾️

### Pattern Corretto (Previene Loop)

```php
public function getGgAnnoAttribute(?int $value): ?int
{
    // ✅ CACHE: Se già calcolato, ritorna subito (NO save())
    if ($value !== null && ! request()->input('refresh', false)) {
        return $value;
    }
    
    // ✅ GUARD: Record deve esistere
    if ($this->getKey() == null) {
        return null;
    }
    
    // Calcola
    $value = $this->gg_presenza_anno - $this->gg_assenza_anno;
    
    // Setta
    $this->attributes['gg_anno'] = $value;
    
    // ✅ SALVA: Ma solo se non già in cache
    // Alla prossima lettura, il check iniziale ritorna subito
    $this->save();
    
    return $value;
}
```

**Perché NON fa loop:**
1. **Prima chiamata**: `$value` è `null`, calcola e salva
2. **Durante `save()`**: Laravel legge `gg_anno`
3. **Seconda chiamata accessor**: `$value !== null` → ritorna subito **SENZA** chiamare `save()`
4. **Nessun loop** ✅

## Implementazione Corretta

### Step 1: Ripristinare `$this->save()`

Tutti gli accessor che calcolano valori derivati DEVONO salvare:

```php
// Lista accessor da correggere:
- getGgCatecoPosfunNoAszAttribute()
- getGgEsperienzaNoAszAttribute()
- getGgIntegParamsAszAttribute()
- getPostTypeAttribute()
- getPosfunvalAttribute()
- getGgAttribute()
- getGgAszAttribute()
- getGgNoAszAttribute()
- getGgFuoriSedeNoAszAttribute()
- getHhAszAttribute()
- getHhAszInSedeAttribute()
- getHhAszFuoriSedeAttribute()
- getGgAszInSedeAttribute()
- getGgAszFuoriSedeAttribute()
- getGgAszCatecoAttribute()
- getGgAszCatecoInSedeAttribute()
- getGgAszCatecoPosfunInSedeAttribute()
- getGgCatecoNoAszAttribute()
- getProproAttribute()
- getGgCatecoPosfunInSedeNoAszAttribute()
- getGgCatecoPosfunAttribute()
- getGgCatecoSupAttribute()
- getGgCatecoSupInSedeAttribute()
- getGgCatecoNoPosfunNoAszAttribute()
- getGgCatecoInSedeAttribute()
- getGgCatecoAttribute()
- getGgCatecoPosfunInSedeAttribute()
- getGgAszCatecoFuoriSedeAttribute()
- getGgAszCatecoPosfunFuoriSedeAttribute()
- getGgCatecoSupFuoriSedeAttribute()
```

### Step 2: Template Standard

```php
public function get{Campo}Attribute(?{Type} $value): ?{Type}
{
    // Cache check
    if ($value !== null && ! request()->input('refresh', 0)) {
        return $value;
    }
    
    // Guard: record must exist
    if ($this->getKey() == null) {
        return null;
    }
    
    // Guard: dependencies must exist
    if ($this->requiredField == null) {
        return null;
    }
    
    // Calculate
    $value = $this->calculate{Campo}();
    
    // Set attribute
    $this->attributes['{campo}'] = $value;
    
    // Persist
    $this->save();
    
    return $value;
}
```

## Testing

### Test Unitario

```php
test('accessor calculates and persists value', function () {
    $scheda = Scheda::factory()->create([
        'gg_cateco_posfun_in_sede' => 100,
        'gg_asz_cateco_posfun' => 10,
    ]);
    
    // Prima lettura: calcola e salva
    $value = $scheda->gg_cateco_posfun_no_asz;
    
    expect($value)->toBe(90);
    
    // Ricarica da DB
    $scheda->refresh();
    
    // Valore persistito nel DB
    expect($scheda->getAttributes()['gg_cateco_posfun_no_asz'])->toBe(90);
    
    // Seconda lettura: ritorna cached (no ricalcolo)
    DB::shouldReceive('update')->never();
    $value2 = $scheda->gg_cateco_posfun_no_asz;
    expect($value2)->toBe(90);
});
```

### Test Refresh

```php
test('refresh parameter forces recalculation', function () {
    $scheda = Scheda::find(1);
    
    // Valore cached
    $old = $scheda->gg_cateco_posfun_no_asz;
    
    // Modifica dipendenze
    $scheda->gg_cateco_posfun_in_sede = 200;
    $scheda->save();
    
    // Senza refresh: ritorna cached
    request()->merge(['refresh' => 0]);
    expect($scheda->gg_cateco_posfun_no_asz)->toBe($old);
    
    // Con refresh: ricalcola
    request()->merge(['refresh' => 1]);
    $new = $scheda->gg_cateco_posfun_no_asz;
    expect($new)->not->toBe($old);
});
```

## Performance Impact

### Scenario: Edit Record con 30 Campi Calcolati

**Con Fix Errato (no save):**
- Prima lettura: 30 calcoli complessi
- Seconda lettura: 30 calcoli complessi (non persistiti!)
- Terza lettura: 30 calcoli complessi
- **Totale**: 90 calcoli

**Con Fix Corretto (con save):**
- Prima lettura: 30 calcoli + 30 save
- Seconda lettura: 0 calcoli (cached)
- Terza lettura: 0 calcoli (cached)
- **Totale**: 30 calcoli + 30 save

**Vantaggio:**
- Dopo prima lettura: **100% più veloce**
- Dati persistiti: **storicizzazione corretta**
- Activity log: **valori corretti**

## Conclusione

Il fix precedente che rimuoveva `$this->save()` era **sbagliato** perché:
1. ❌ Non persiste i valori calcolati
2. ❌ Degrada performance (ricalcolo continuo)
3. ❌ Perde dati storici
4. ❌ Activity log incompleto

Il pattern corretto è:
1. ✅ Check `getKey() == null` prima di salvare
2. ✅ Cache check all'inizio
3. ✅ Calcola valore
4. ✅ Setta in `$this->attributes[]`
5. ✅ **Chiama `$this->save()`** per persistere

Questo **NON causa loop infiniti** grazie al cache check iniziale.

---

**Creato**: 2025-10-29  
**Autore**: Analisi Business Logic  
**Status**: ✅ PATTERN CORRETTO DOCUMENTATO
