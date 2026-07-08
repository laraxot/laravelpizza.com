# SchedaTrait - Refactoring Plan: Rimuovere `$this->save()` dagli Accessor

## Problema

**SchedaTrait** ha 15+ accessor che chiamano `$this->save()` al loro interno.

Questo è un **ANTI-PATTERN CRITICO** che causa:
1. Side effects inattesi durante lettura attributi
2. Errori "Duplicate Entry" con Activity Log
3. Performance degradate (save multipli)
4. Debugging difficile
5. Comportamento imprevedibile

## Accessor Problematici

### Lista Completa (15+ metodi)

```bash
cd laravel
grep -n "->save()" Modules/Sigma/app/Models/Traits/SchedaTrait.php | grep "Attribute"
```

**Risultato**:
1. `getProproAttribute()` - linea 617
2. `getGgAttribute()` - linea 241
3. `getGgAszAttribute()` - linea 265
4. `getGgNoAszAttribute()` - linea ~290
5. `getValoreDifferenzialeRapportatoPtAttribute()` - linea 1227
6. `getPuntProgressioneFinaleAttribute()` - linea 1365
7. `getValutatoreIdAttribute()` - linea 1392, 1411
8. `getPerfIndMediaAttribute()` - linea 1891
9. `getPerfIndCountLast3YearsAttribute()` - linea 1911
10. `getExcellencesCountLast3yearsAttribute()` - linea ~1935
11. + altri in SchedaMutator.php (es. `getPosizioneEcoAttribute()` - linea 160)

## Piano di Refactoring

### Fase 1: Pattern Standardizzato

Per OGNI accessor:

#### PRIMA (Anti-Pattern)

```php
public function getProproAttribute(?int $value): ?int
{
    if ($value != null) {
        return $value;
    }

    $this->propro = $this->getPropro();
    $this->save();  // ← RIMUOVERE

    return $value;
}
```

#### DOPO (Pattern Corretto)

```php
/**
 * Accessor senza side effects.
 * Calcola il valore ma NON salva automaticamente.
 */
public function getProproAttribute(?int $value): ?int
{
    if ($value != null) {
        return $value;
    }

    // Calcola e cacha in memoria per questa request
    $calculated = $this->calculateProproValue();
    $this->attributes['propro'] = $calculated;
    
    return $calculated;
}

/**
 * Metodo estratto per calcolo propro.
 */
protected function calculateProproValue(): ?int
{
    return $this->getPropro();
}

/**
 * Metodo esplicito per persistere il valore calcolato.
 */
public function updatePropro(): void
{
    $this->propro = $this->calculateProproValue();
    $this->save();
}
```

### Fase 2: Observer per Persistenza Automatica

Se serve calcolare e salvare automaticamente durante save:

```php
// Modules/Sigma/app/Observers/SchedaObserver.php

class SchedaObserver
{
    /**
     * Handle before saving a Scheda.
     * Calcola campi derivati se necessario.
     */
    public function saving(BaseScheda $scheda): void
    {
        // Calcola propro se null
        if ($scheda->propro === null && $scheda->matr !== null) {
            $scheda->attributes['propro'] = $scheda->calculateProproValue();
        }
        
        // Calcola gg se null
        if ($scheda->gg === null && $scheda->qua2kd !== null) {
            $scheda->attributes['gg'] = $scheda->calculateGgValue();
        }
        
        // ... altri campi calcolati ...
    }
}

// Registrare in ServiceProvider
BaseScheda::observe(SchedaObserver::class);
```

### Fase 3: Metodi di Update Espliciti

Per chiamate esplicite da controller/service:

```php
// Modules/Sigma/app/Actions/UpdateSchedaCalculatedFieldsAction.php

class UpdateSchedaCalculatedFieldsAction
{
    public function execute(BaseScheda $scheda, array $fields = []): void
    {
        if (empty($fields)) {
            // Update tutti i campi calcolati
            $fields = ['propro', 'gg', 'gg_asz', 'valutatore_id', /* ... */];
        }
        
        foreach ($fields as $field) {
            $method = 'update' . Str::studly($field);
            if (method_exists($scheda, $method)) {
                $scheda->$method();
            }
        }
    }
}

// Utilizzo
app(UpdateSchedaCalculatedFieldsAction::class)->execute($scheda, ['propro', 'gg']);
```

## Checklist per Ogni Accessor

- [ ] Rimuovere `$this->save()`
- [ ] Estrarre logica calcolo in metodo `calculate*Value()`
- [ ] Creare metodo `update*()` per persistenza esplicita
- [ ] Cachare valore in `$this->attributes[]` nell'accessor
- [ ] Aggiornare test esistenti
- [ ] Creare test regressione
- [ ] Verificare chiamate esistenti nel codice
- [ ] Aggiornare documentazione

## Priorità Accessor da Refactorare

### P0 (CRITICO - Blocca Activity Log)

1. `getProproAttribute()` - usato frequentemente
2. `getGgAttribute()` - usato in calcoli
3. `getValutatoreIdAttribute()` - critico per assegnazioni

### P1 (ALTA - Performance Impact)

4. `getGgAszAttribute()` - query pesanti
5. `getGgNoAszAttribute()` - query pesanti
6. `getPerfIndMediaAttribute()` - calcoli complessi

### P2 (MEDIA - Meno Usati)

7-15. Altri accessor

## Test di Regressione

```php
// tests/Feature/Models/SchedaTrait/AccessorWithoutSaveTest.php

test('accessor does not save automatically', function () {
    $scheda = IndennitaResponsabilita::factory()->create(['propro' => null]);
    
    // Accesso accessor
    $propro = $scheda->propro;
    
    // Verifica che NON sia stato salvato
    $scheda->refresh();
    expect($scheda->getAttributes()['propro'])->toBeNull();
});

test('update method persists value', function () {
    $scheda = IndennitaResponsabilita::factory()->create(['propro' => null]);
    
    // Update esplicito
    $scheda->updatePropro();
    
    // Verifica persistenza
    $scheda->refresh();
    expect($scheda->propro)->not->toBeNull();
});

test('observer calculates on save', function () {
    $scheda = IndennitaResponsabilita::factory()->create(['propro' => null, 'matr' => 12345]);
    
    // Save triggera observer
    $scheda->save();
    
    // Verifica che propro sia stato calcolato
    $scheda->refresh();
    expect($scheda->propro)->not->toBeNull();
});
```

## Timeline

### Sprint 1 (Settimana 1-2)
- [ ] Audit completo accessor
- [ ] Setup pattern e template
- [ ] Refactoring accessor P0 (3 accessor)
- [ ] Test regressione P0

### Sprint 2 (Settimana 3-4)
- [ ] Refactoring accessor P1 (6 accessor)
- [ ] Implementare Observer pattern
- [ ] Test regressione P1

### Sprint 3 (Settimana 5-6)
- [ ] Refactoring accessor P2 (6+ accessor)
- [ ] Test completi
- [ ] Riabilitare Activity Log
- [ ] Monitoraggio produzione

## Deliverables

1. **Refactoring Code**: Tutti accessor senza `$this->save()`
2. **Observer Class**: Per calcoli automatici durante save
3. **Action Class**: Per update espliciti campi calcolati
4. **Test Suite**: Copertura completa accessor refactorati
5. **Documentazione**: Pattern e motivazioni
6. **Migration Plan**: Per passaggio graduale

## Rischi e Mitigazioni

| Rischio | Impatto | Mitigazione |
|---------|---------|-------------|
| Campi non più calcolati automaticamente | ALTO | Observer pattern per calcolo during save |
| Codice esistente dipende da side effect | MEDIO | Audit chiamate + metodi update espliciti |
| Test esistenti si rompono | BASSO | Fix test + test regressione |
| Regressione funzionalità | ALTO | Test completi + rollout graduale |

## Collegamenti

- [Activity Log - Duplicate Entry Error](../../Activity/docs/errori/duplicate-entry-accessor-save.md)
- [BaseScheda Activity Log](../../Ptv/docs/models/base-scheda-activity-log.md)
- [SchedaTrait Source](../app/Models/Traits/SchedaTrait.php)

---

**Created**: 27 Ottobre 2025  
**Status**: TODO  
**Priority**: P0 (blocca Activity Log)  
**Assigned**: TBD  
**ETA**: 6 settimane (3 sprint)


