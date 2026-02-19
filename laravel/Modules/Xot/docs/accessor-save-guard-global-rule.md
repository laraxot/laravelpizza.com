# Regola Globale: Guard su getKey() Prima di save() negli Accessor

## Analisi Business Logic

### Problema Universale

**Scenario**:
```php
// Creazione nuovo modello
$model = new Scheda(['nome' => 'Test']);

// Accessor viene chiamato (es. per form Filament)
$valore = $model->perf_ind_media;

// Dentro accessor:
public function getPerfIndMediaAttribute(?float $value): ?float {
    $media = $this->calcola();
    $this->save(); // ❌ ERRORE! getKey() è null, tenta INSERT
}
```

**Risultato**:
- `Duplicate Entry` error SE id è fillable
- `NULL in PRIMARY KEY` error altrimenti
- Comportamento imprevedibile

### Soluzione Universale

**Pattern Obbligatorio**:
```php
public function get<Nome>Attribute(?type $value): ?type
{
    // ... cache check ...

    // ✅ GUARD OBBLIGATORIO
    if (null == $this->getKey()) {
        return null; // O return $value se appropriato
    }

    // Calcolo...
    $newValue = /* ... */;

    // Ora save() è sicuro
    $this->save();

    return $newValue;
}
```

## Filosofia della Regola

### Perché Questa Regola?

**Politica**: "Accessor gestisce lifecycle di record ESISTENTI, non crea nuovi record"

**Religione**:
> "Non salverai ciò che non esiste.
> Il null è il guardiano dell'esistenza.
> La Primary Key è prova di vita nel database."

**Filosofia (Tao)**:
> "L'accessor è come un giardiniere:
> innaffia le piante (record esistenti),
> ma non pianta semi (nuovi record).
> Il seme lo pianta il create()."

### Scopo Business

**Nei sistemi PA (PTVX)**:
- Schede valutazione calcolano valori durante edit
- Performance evaluation aggrega dati storici
- Indennità calcola importi da timbrature

**Tutti questi calcoli**:
- Richiedono record esistente nel DB
- Accedono a relazioni (anag, integparam, etc)
- Persistono risultati per performance

**Se permettiamo save() senza PK**:
- ❌ Calcoli su dati incompleti
- ❌ Relazioni non risolte (FK null)
- ❌ Errori di integrità referenziale

## Regola Operativa

### Per TUTTI i Moduli

**Obbligatorio in**:
1. Tutti i MutatorTrait
2. Tutti i Model con accessor che salvano
3. Tutti i Trait con logica di calcolo + persistenza

**Pattern**:
```php
// SEMPRE prima di save() in accessor:

if (null == $this->getKey()) {
    return null; // Per accessor che calcolano
    // O
    return $value; // Per accessor che validano
}
```

### Eccezioni

**Nessuna eccezione** per accessor che:
- Chiamano `save()`
- O chiamano `update()`
- O modificano `$this->attributes` + save

**Unica eccezione**: Metodi `boot()`, `creating()`, `created()` eventi lifecycle

## File da Verificare

### Moduli con MutatorTrait (Priorità ALTA)

1. ✅ **Sigma/Models/Traits/SchedaTrait.php** - GIÀ VERIFICATO
2. ⏳ **Sigma/Models/Traits/Mutators/SchedaMutator.php**
3. ⏳ **Performance/Models/Traits/MutatorTrait.php**
4. ⏳ **IndennitaResponsabilita/Models/Traits/MutatorTrait.php**
5. ⏳ **IndennitaCondizioniLavoro/Models/Traits/MutatorTrait.php**

### Moduli con Accessor Specifici (Priorità MEDIA)

6. ⏳ **Rating/Models/Traits/RatingTrait.php**
7. ⏳ **Ptv/Models/BaseScheda.php**
8. ⏳ **Progressioni/Models/Schede.php**
9. ⏳ **Performance/Models/StabiDirigente.php**
10. ⏳ **User/Models/BaseTenant.php**

## Pattern Identificati

### Pattern A: Accessor con Calcolo + Save

```php
// PRIMA (vulnerabile)
public function getTotaleAttribute(): float {
    $totale = $this->campo1 + $this->campo2;
    $this->save(); // ❌ Pericoloso!
    return $totale;
}

// DOPO (safe)
public function getTotaleAttribute(): float {
    if (null == $this->getKey()) {
        return 0.0; // O null se appropriato
    }

    $totale = $this->campo1 + $this->campo2;
    $this->save(); // ✅ Sicuro
    return $totale;
}
```

### Pattern B: Accessor con Update + Save

```php
// PRIMA
public function getStatusAttribute(): string {
    $this->attributes['status'] = $this->calcolaStatus();
    $this->save(); // ❌ Pericoloso!
    return $this->attributes['status'];
}

// DOPO
public function getStatusAttribute(): string {
    if (null == $this->getKey()) {
        return $this->calcolaStatus(); // Calcola ma non salva
    }

    $this->attributes['status'] = $this->calcolaStatus();
    $this->save(); // ✅ Sicuro
    return $this->attributes['status'];
}
```

### Pattern C: Accessor con Aggregazione + Save

```php
// PRIMA
public function getMediaAttribute(): float {
    $records = self::where('parent_id', $this->id)->get(); // ❌ Se id null?
    $media = $records->avg('valore');
    $this->save(); // ❌ Pericoloso!
    return $media;
}

// DOPO
public function getMediaAttribute(): float {
    if (null == $this->getKey()) {
        return 0.0; // Nessun aggregato possibile
    }

    $records = self::where('parent_id', $this->id)->get(); // ✅ id esiste
    $media = $records->avg('valore');
    $this->save(); // ✅ Sicuro
    return $media;
}
```

## Piano Implementazione

### Fase 1: Documentazione (Oggi)
- [x] Analisi filosofica regola
- [x] Identificazione file coinvolti
- [x] Pattern e template
- [x] Documentazione in Xot (globale)

### Fase 2: Sigma (GIÀ FATTO)
- [x] SchedaTrait.php - 15 accessor già fixati ✅

### Fase 3: Altri Moduli (Prossime Sessioni)

**Settimana 1**:
- [ ] Performance/MutatorTrait
- [ ] IndennitaResponsabilita/MutatorTrait
- [ ] IndennitaCondizioniLavoro/MutatorTrait

**Settimana 2**:
- [ ] Rating/RatingTrait
- [ ] Ptv/BaseScheda
- [ ] Progressioni/Schede

**Settimana 3**:
- [ ] Altri moduli + cleanup finale

## Checklist Verifica

Per ogni file con accessor + save():

- [ ] 🔒 Acquisire lock file
- [ ] 📖 Leggere tutti gli accessor del file
- [ ] 🔍 Identificare quali chiamano save()/update()
- [ ] ✅ Verificare presenza guard `if (null == $this->getKey())`
- [ ] ➕ Aggiungere guard se mancante
- [ ] 📝 Documentare in PHPDoc se comportamento speciale
- [ ] 🧪 Testare (se possibile)
- [ ] 🔓 Rilasciare lock
- [ ] 📄 Aggiornare docs modulo

## Best Practices

### DO ✅

1. **Guard immediato dopo cache check**
2. **Return appropriato** (null per calcoli, value per validazioni)
3. **Documentare** se guard ha logica speciale
4. **Testare** dopo ogni modifica

### DON'T ❌

1. **Mai save() senza guard** su getKey()
2. **Mai assumere** PK esiste sempre
3. **Mai rimuovere guard** esistenti
4. **Mai saltare** testing dopo modifica

## Testing

### Test Guard PK

```php
test('accessor ritorna null se model senza PK', function () {
    $model = new Scheda(['nome' => 'Test']);

    // Model non salvato, nessuna PK
    expect($model->getKey())->toBeNull();

    // Accessor deve gestire gracefully
    $valore = $model->perf_ind_media;

    expect($valore)->toBeNull();
    // E non deve aver tentato save()
});

test('accessor salva se model ha PK', function () {
    $model = Scheda::factory()->create();

    expect($model->getKey())->not->toBeNull();

    $valore = $model->perf_ind_media;

    expect($valore)->not->toBeNull();
    // E deve aver salvato
    $model->refresh();
    expect($model->perf_ind_media)->toBe($valore);
});
```

## Collegamenti

### Implementazioni Modulo-Specifiche
- [Sigma - SchedaTrait Fix](../../sigma/docs/fix-duplicate-entry-error-summary.md)
- [Performance - MutatorTrait](../../performance/docs/mutator-guard-fix.md) (da creare)
- [IndennitaCondizioniLavoro - MutatorTrait](../../indennitacondizionilavoro/docs/accessor-guard.md) (da creare)

### Documentazione Pattern
- [Accessor Pattern](../../sigma/docs/scheda-trait-accessor-pattern.md)
- [Refactoring Philosophy](../../sigma/docs/accessor-refactoring-philosophy.md)

### Regole Globali
- [.cursor/rules/accessor-save-guard.mdc](../../../.cursor/rules/accessor-save-guard.mdc) (da creare)
- [.windsurf/rules/accessor-save-guard.mdc](../../../.windsurf/rules/accessor-save-guard.mdc) (da creare)

---

**Creato**: [DATE]
**Tipo**: Regola Architettutale Globale
**Applicazione**: Tutti i moduli
**Severità**: 🔴 CRITICA
**Status**: 📖 Documentata, 🔄 Implementazione in corso
