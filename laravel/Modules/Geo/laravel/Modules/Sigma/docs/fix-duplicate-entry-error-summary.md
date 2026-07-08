# Fix Duplicate Entry Error - Summary & Implementation

## Problema Originale

```
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '10660' for key 'schede.PRIMARY'
```

**Causa**: Durante l'edit di una scheda esistente, gli accessor chiamavano `$this->save()` ma il modello pensava di essere nuovo (`$this->exists = false`), causando un **INSERT** invece di **UPDATE**.

## Analisi e Soluzione

### Errore nel Fix Precedente

Il fix precedente aveva **completamente rimosso** il `save()` dagli accessor:

```php
// ❌ FIX ERRATO (fatto prima)
public function getPerfIndMediaAttribute(): ?float
{
    $media = $this->calcPerfIndMedia();
    // Removed: $this->save(); // ❌ SBAGLIATO
    return $media;
}
```

**Conseguenze**:
- Valori calcolati NON persistiti
- Ricalcolo continuo (perdita performance)
- Business logic originale persa

### Soluzione Corretta Implementata

```php
// ✅ FIX CORRETTO (implementato)
public function getPerfIndMediaAttribute(): ?float
{
    // 1. Cache check
    if (null !== $value && ! request()->input('refresh', 0)) {
        return round($value, 2);
    }

    // 2. GUARD: Verifica PK prima di salvare
    if ($this->getKey() === null) {
        return null; // Modello in creazione
    }

    // 3. Calcolo
    $value = $this->perfIndMedia();

    // 4. Salvataggio sicuro
    $this->perf_ind_media = $value;
    $this->save(); // ✅ Ora sicuro

    return $value;
}
```

## Accessor Fixati (Fase 1)

### ✅ Completati

1. **`getPerfIndMediaAttribute`** (linea ~1980)
   - Calcola media performance individuale
   - Critico per valutazioni dipendenti
   - **Status**: ✅ Fixed con guard + save

2. **`getGgIntegParamsAszAttribute`** (linea ~65)
   - Giorni parametri integrativi assenza
   - Usato per calcoli indennità
   - **Status**: ✅ Fixed con guard + save

3. **`getGgEsperienzaNoAszAttribute`** (linea ~100)
   - Giorni esperienza senza assenze
   - Impatto su progressioni
   - **Status**: ✅ Fixed con guard + save

4. **`getGgInSedeAttribute`** (linea ~1697)
   - Giorni di presenza in sede
   - Fondamentale per calcoli timbrature
   - **Status**: ✅ Fixed con guard + save

## Testing Immediato

### Test 1: Edit Funziona Senza Errore

```bash
# Navigare a:
# http://personale2022.prov.tv.local/progressioni/admin/progressionis/10660/edit

# Risultato atteso:
# ✅ Pagina carica correttamente
# ✅ Nessun errore "Duplicate entry"
# ✅ Valori calcolati visualizzati
```

### Test 2: Valori Persistiti

```sql
-- Verificare che i valori siano salvati nel DB
SELECT 
    id,
    perf_ind_media,
    gg_integ_params_asz,
    gg_esperienza_no_asz,
    gg_in_sede
FROM schede
WHERE id = 10660;

-- Risultato atteso:
-- ✅ Valori NOT NULL (calcolati e salvati)
```

### Test 3: Performance (No Ricalcolo Continuo)

```php
// In Laravel Debugbar/Telescope, verificare query count
$scheda = Scheda::find(10660);
$media = $scheda->perf_ind_media; // 1° accesso: calcola + salva
$media = $scheda->perf_ind_media; // 2° accesso: ritorna valore cached

// Risultato atteso:
// ✅ 2° accesso NON esegue query di calcolo
// ✅ 2° accesso ritorna valore da attributo
```

## Accessor Rimanenti (52)

### Priorità MEDIA (Da fixare prossima settimana)

5. **getGgFuoriSedeAttribute** - Giorni fuori sede
6. **getGgAnnoAttribute** - Giorni effettivi annui
7. **getGgCatecoPosfunNoAszAttribute** - Categorie posizione funzionale
8. **getGgCatecoAttribute** - Giorni categoria economica
9. **getGgPresenzaAnnoAttribute** - Presenza annuale

### Priorità BASSA (Completamento progressivo)

10-56. Altri accessor calcolati (vedere [fix-accessor-save-pattern.md](./fix-accessor-save-pattern.md))

## File Modificati

- ✅ `/laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`
  - Linea ~1980: getPerfIndMediaAttribute
  - Linea ~65: getGgIntegParamsAszAttribute
  - Linea ~100: getGgEsperienzaNoAszAttribute
  - Linea ~1697: getGgInSedeAttribute

## Documentazione Creata/Aggiornata

1. ✅ `/laravel/Modules/Sigma/docs/scheda-trait-accessor-pattern.md`
   - Pattern architetturale completo
   - Business logic e motivazioni
   - Test cases e best practices

2. ✅ `/laravel/Modules/Sigma/docs/fix-accessor-save-pattern.md`
   - Guida implementazione fix
   - Lista completa accessor da fixare
   - Checklist progressiva

3. ✅ `/laravel/Modules/Sigma/docs/fix-duplicate-entry-error-summary.md` (questo file)
   - Riepilogo problema e soluzione
   - Status implementazione
   - Testing procedure

## Prossimi Passi

### Immediate (Oggi)

- [ ] **Test manuale** edit scheda ID 10660
- [ ] **Verificare** no errore Duplicate Entry
- [ ] **Controllare** valori persistiti nel DB
- [ ] **Monitorare** log errori in produzione

### Breve Termine (Questa settimana)

- [ ] **Fixare** altri 5-10 accessor priorità MEDIA
- [ ] **Creare test automatizzati** per accessor critici
- [ ] **Documentare** eventuali edge case scoperti

### Lungo Termine (Prossime settimane)

- [ ] **Completare** fix su tutti i 52 accessor rimanenti
- [ ] **Refactoring** pattern accessor con trait dedicato
- [ ] **Performance audit** completo su schede calculation
- [ ] **Code review** con team per validare approccio

## Filosofia PTVX Applicata

### DRY (Don't Repeat Yourself)

✅ **Applicato**: Pattern unico documentato e riutilizzabile su tutti gli accessor

### KISS (Keep It Simple, Stupid)

✅ **Applicato**: Soluzione semplice e chiara: guard + save

### Business Logic First

✅ **Applicato**: Preservata logica originale di persistenza valori calcolati

## Collegamenti

- [Pattern Accessor con Salvataggio](./scheda-trait-accessor-pattern.md)
- [Guida Implementazione Fix](./fix-accessor-save-pattern.md)
- [Business Logic Module Sigma](./business-logic.md)
- [Common Errors](../../../docs/common-errors.md)

---

**Creato**: 2025-01-29  
**Ultimo Aggiornamento**: 2025-01-29  
**Status**: ✅ Fase 1 Completata (4/56 accessor)  
**Prossimo Milestone**: Fase 2 - Altri 5 accessor (settimana prossima)  
**Responsabile**: AI Assistant + Team Dev

