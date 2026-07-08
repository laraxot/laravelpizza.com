# Pattern Accessor con Salvataggio in SchedaTrait

## Business Logic

### Scopo
Il trait `SchedaTrait` implementa accessor che calcolano valori derivati e li **persistono automaticamente** nel database per ottimizzazione delle performance.

### Perché Salvare negli Accessor?

**Motivazione Business**:
- Le schede di progressione contengono calcoli complessi su performance individuali
- I calcoli coinvolgono aggregazioni su dati storici multi-anno
- Performance critica: evitare ricalcolo ad ogni accesso
- Denormalizzazione controllata per query veloci

**Trade-off Architetturale**:
- ✅ **PRO**: Performance drasticamente migliorate
- ✅ **PRO**: Consistenza garantita (ricalcolo automatico quando necessario)
- ⚠️ **CON**: Logica non convenzionale (accessor che modifica stato)
- ⚠️ **CON**: Richiede gestione attenta del ciclo di vita del modello

## Pattern Implementato

### Accessor con Salvataggio Condizionale

```php
/**
 * Accessor per media performance individuale.
 * 
 * IMPORTANTE: Questo accessor SALVA il valore calcolato nel database
 * per ottimizzare le performance delle query successive.
 * 
 * @return float|null
 */
public function getPerfIndMediaAttribute(): ?float
{
    // CRITICO: Verificare che il modello abbia una primary key
    // Se non ce l'ha, è in fase di creazione e non possiamo salvare
    if ($this->getKey() === null) {
        return null;
    }
    
    // Calcolo del valore
    $media = $this->calcPerfIndMedia();
    
    // Salvataggio del valore calcolato
    // Questo aggiorna il record esistente nel database
    $this->save();
    
    return $media;
}
```

### Ciclo di Vita del Modello

```php
// SCENARIO 1: Creazione di un nuovo record
$scheda = new Scheda();
$scheda->nome = 'Test';
// getKey() === null → accessor ritorna null senza salvare
$media = $scheda->perf_ind_media; // null

$scheda->save(); // Prima save: crea il record con ID
// getKey() !== null → accessor può ora calcolare e salvare
$media = $scheda->perf_ind_media; // 85.5 (calcolato e salvato)

// SCENARIO 2: Edit di un record esistente
$scheda = Scheda::find(10660);
// getKey() === 10660 → accessor calcola e salva
$media = $scheda->perf_ind_media; // 92.3 (ricalcolato e aggiornato)
```

## Problema Risolto: Duplicate Entry Error

### Causa Radice

```php
// PRIMA (ERRATO): Accessor chiamato durante form load
Route::get('/schede/{id}/edit', function ($id) {
    $scheda = Scheda::find($id); // ID = 10660, exists = true
    
    // Filament carica il form
    // Durante il caricamento, viene acceduto $scheda->perf_ind_media
    // L'accessor chiama $this->save()
    // 
    // MA SE $this->exists è diventato false per qualche motivo:
    // → Laravel fa INSERT invece di UPDATE
    // → Duplicate entry '10660' for key 'PRIMARY'
});
```

### Fix Implementato

```php
public function getPerfIndMediaAttribute(): ?float
{
    // GUARDIA: Non salvare se non abbiamo una primary key
    if ($this->getKey() === null) {
        return null; // Modello in creazione, nessun salvataggio
    }
    
    // SAFE: A questo punto sappiamo che:
    // 1. Il modello ha una PK
    // 2. Il modello esiste nel database
    // 3. save() farà un UPDATE, non un INSERT
    
    $media = $this->calcPerfIndMedia();
    $this->save();
    
    return $media;
}
```

## Best Practices

### Quando Usare Questo Pattern

✅ **Usare quando**:
- Calcoli costosi che richiedono denormalizzazione
- Dati aggregati consultati frequentemente
- Performance critica per query di lettura
- Aggiornamenti sporadici del valore calcolato

❌ **NON usare quando**:
- Dati che cambiano frequentemente
- Calcoli semplici e veloci
- Requisito di consistenza real-time
- Logica può essere risolta con view o query ottimizzate

### Checklist Implementazione

- [ ] **Guard sulla Primary Key**: Sempre verificare `getKey() === null`
- [ ] **Documentazione Esplicita**: Commentare che l'accessor salva
- [ ] **Test del Ciclo di Vita**: Testare creazione, lettura, aggiornamento
- [ ] **Performance Monitoring**: Verificare che non crei loop infiniti
- [ ] **Transaction Safety**: Considerare impatto su transazioni DB

### Anti-Pattern da Evitare

```php
// ❌ ERRATO: Rimuovere completamente il save()
public function getPerfIndMediaAttribute(): ?float
{
    $media = $this->calcPerfIndMedia();
    // Manca il save() → valore non persistito → ricalcolo continuo
    return $media;
}

// ❌ ERRATO: Salvare sempre senza guard
public function getPerfIndMediaAttribute(): ?float
{
    $media = $this->calcPerfIndMedia();
    $this->save(); // Può fallire se getKey() === null
    return $media;
}

// ✅ CORRETTO: Guard + Save
public function getPerfIndMediaAttribute(): ?float
{
    if ($this->getKey() === null) {
        return null;
    }
    
    $media = $this->calcPerfIndMedia();
    $this->save();
    return $media;
}
```

## Testing

### Test Case: Creazione

```php
test('accessor ritorna null durante creazione', function () {
    $scheda = new Scheda([
        'nome' => 'Test Scheda',
        'cognome' => 'Rossi',
    ]);
    
    // ASSERT: Senza PK, accessor ritorna null
    expect($scheda->perf_ind_media)->toBeNull();
    expect($scheda->getKey())->toBeNull();
});
```

### Test Case: Edit

```php
test('accessor calcola e salva durante edit', function () {
    $scheda = Scheda::factory()->create([
        'perf_ind_2023' => 80.0,
        'perf_ind_2024' => 90.0,
    ]);
    
    // ASSERT: Con PK, accessor calcola e salva
    $media = $scheda->perf_ind_media;
    
    expect($media)->toBeFloat();
    expect($media)->toBe(85.0);
    
    // Verifica che il valore sia stato salvato
    $scheda->refresh();
    expect($scheda->perf_ind_media)->toBe(85.0);
});
```

### Test Case: Duplicate Entry Prevention

```php
test('accessor non causa duplicate entry error durante edit', function () {
    $scheda = Scheda::find(10660);
    
    // ASSERT: L'accesso all'accessor non causa errore
    expect(fn() => $scheda->perf_ind_media)->not->toThrow(
        UniqueConstraintViolationException::class
    );
    
    // ASSERT: Il record è stato aggiornato, non duplicato
    $count = Scheda::where('id', 10660)->count();
    expect($count)->toBe(1);
});
```

## Filosofia PTVX

### Pragmatismo vs Purezza

> "Il codice perfetto è nemico del codice funzionante."  
> — Filosofia PTVX, Capitolo 3: Il Pragmatismo Necessario

**Considerazioni**:
- Salvare in un accessor **viola** il principio di immutabilità degli accessor
- Ma **risolve** un problema reale di performance in un dominio specifico
- È un **trade-off consapevole** documentato e motivato

### Trasparenza

> "Ogni violazione delle convenzioni deve essere documentata,  
> motivata e resa trasparente a chi mantiene il codice."

**Applicazione**:
- ✅ Documentato in questo file
- ✅ Commentato nel codice con `IMPORTANTE:`
- ✅ Test che verificano il comportamento
- ✅ Collegamenti a troubleshooting e business logic

## Collegamenti

### Documentazione Correlata
- [Business Logic Module Sigma](./business-logic.md)
- [Performance Optimization](./performance.md)
- [Troubleshooting Common Errors](./troubleshooting.md)

### Codice Correlato
- `SchedaTrait.php` - Implementazione trait
- `Scheda.php` - Modello principale
- `SchedaTest.php` - Test suite

### Errori Correlati
- [Duplicate Entry Error](../../../docs/common-errors.md#duplicate-entry)
- [Model Exists False Bug](./troubleshooting.md#model-exists-false)

---

**Ultimo aggiornamento**: 2025-01-29  
**Responsabile**: AI Assistant  
**Revisione**: Richiesta dopo implementazione fix

