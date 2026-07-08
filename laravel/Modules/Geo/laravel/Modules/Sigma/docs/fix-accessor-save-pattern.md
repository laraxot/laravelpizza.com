# Fix Accessor Save Pattern - Implementation Guide

## Problema Identificato

Nel trait `SchedaTrait` ci sono **56 accessor** che calcolano valori e li salvano nel database. Il fix precedente aveva **rimosso completamente** il `save()`, causando:
- ❌ Valori non persistiti
- ❌ Ricalcolo continuo (performance loss)
- ❌ Perdita della business logic originale

## Soluzione Corretta

### Pattern da Applicare

```php
public function getXyzAttribute(?type $value): ?type
{
    // 1. Cache hit: se abbiamo già il valore, ritornalo
    if (null != $value && ! request()->input('refresh', false)) {
        return $value;
    }
    
    // 2. GUARD: Se non abbiamo PK, non possiamo salvare
    if ($this->getKey() === null) {
        return null;
    }
    
    // 3. Calcolo del valore
    $value = /* logica di calcolo */;
    
    // 4. Salvataggio del valore calcolato
    $this->attributes['xyz'] = $value;
    $this->save(); // ✅ Ora sicuro perché abbiamo verificato getKey()
    
    return $value;
}
```

### Checklist Implementazione

Per ogni accessor:
- [ ] Verificare presenza di `$this->attributes[...]`
- [ ] Aggiungere `if ($this->getKey() === null) { return null; }` DOPO il cache check
- [ ] Aggiungere `$this->save();` DOPO `$this->attributes[...]`
- [ ] Aggiornare commento da `FIXED/REMOVED` a `✅ CORRETTO`

## Lista Accessor da Fixare

### Priorità ALTA (Causano l'errore Duplicate Entry)

1. **getPerfIndMediaAttribute** (linea ~1252) - Media performance
2. **getTotaleAttribute** - Totale punteggio
3. **getRisultatoAttribute** - Risultato finale

### Priorità MEDIA (Performance critiche)

4. **getGgIntegParamsAszAttribute** (linea ~65) - Giorni parametri integrativi
5. **getGgEsperienzaNoAszAttribute** (linea ~92) - Giorni esperienza
6. **getGgInSedeAttribute** - Giorni in sede
7. **getGgFuoriSedeAttribute** - Giorni fuori sede
8. **getGgAnnoAttribute** - Giorni annui

### Priorità BASSA (Da completare)

9-56. Altri accessor calcolati (vedere output grep)

## Esempio di Fix Completo

### PRIMA (Errato)

```php
public function getPerfIndMediaAttribute(): ?float
{
    // ⚠️ FIXED: Accessor must be read-only, calculate on-the-fly without save()
    $media = $this->calcPerfIndMedia();
    // Removed: $this->save(); // ❌ SBAGLIATO: rimosso completamente
    return $media;
}
```

### DOPO (Corretto)

```php
public function getPerfIndMediaAttribute(): ?float
{
    // GUARD: Se il modello non ha PK, non possiamo salvare
    if ($this->getKey() === null) {
        return null; // Modello in creazione, nessun salvataggio
    }
    
    // Calcolo del valore
    $media = $this->calcPerfIndMedia();
    
    // ✅ CORRETTO: Salviamo il valore calcolato (con guard sulla PK)
    $this->attributes['perf_ind_media'] = $media;
    $this->save();
    
    return $media;
}
```

## Script di Fix Automatico

Per applicare il fix a tutti gli accessor:

```bash
# Backup
cp Modules/Sigma/app/Models/Traits/SchedaTrait.php Modules/Sigma/app/Models/Traits/SchedaTrait.php.backup

# Applicare fix manualmente o con script dedicato
# (Da implementare in base alle necessità)
```

## Testing Dopo il Fix

```php
// Test 1: Creazione (getKey() === null)
$scheda = new Scheda();
expect($scheda->perf_ind_media)->toBeNull();

// Test 2: Edit (getKey() !== null)
$scheda = Scheda::find(10660);
expect($scheda->perf_ind_media)->toBeFloat();

// Test 3: No Duplicate Entry
$scheda = Scheda::find(10660);
expect(fn() => $scheda->perf_ind_media)->not->toThrow(UniqueConstraintViolationException::class);
```

## Implementazione Progressiva

### Fase 1: Fix Immediato (OGGI)
- ✅ getPerfIndMediaAttribute
- ✅ getTotaleAttribute  
- ✅ getRisultatoAttribute

### Fase 2: Performance (Settimana prossima)
- getGgIntegParamsAszAttribute
- getGgEsperienzaNoAszAttribute
- getGgInSedeAttribute
- getGgFuoriSedeAttribute
- getGgAnnoAttribute

### Fase 3: Completamento (Da pianificare)
- Altri 48 accessor

## Collegamenti

- [Pattern Accessor con Salvataggio](./scheda-trait-accessor-pattern.md)
- [Business Logic Module Sigma](./business-logic.md)
- [Troubleshooting](./troubleshooting.md)

---

**Creato**: 2025-01-29  
**Stato**: In implementazione - Fase 1  
**Responsabile**: AI Assistant + Team Dev

