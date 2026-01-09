# Activity Module - Status Attuale

## ⚠️ STATO: Parzialmente Disabilitato

### Modelli con Activity Log Attivo

✅ Modelli che NON estendono `BaseScheda`:
- `User`
- `Team`
- Altri modelli senza SchedaTrait

### Modelli con Activity Log Disabilitato

❌ Modelli che estendono `BaseScheda`:
- `IndennitaResponsabilita`
- `Progressioni`
- `CondizioniLavoro`
- Altri modelli che usano SchedaTrait

## Motivo Disabilitazione

**SchedaTrait** ha 15+ accessor che chiamano `$this->save()` al loro interno. Questo causa:

```
EditRecord::save()
 └─> $record->save()
      └─> LogsActivity::updated()
           └─> $record->toArray()  ← Accede accessor
                └─> getProproAttribute()
                     └─> $this->save()  ← ERRORE!
                          └─> INSERT invece di UPDATE
                               └─> 💥 Duplicate Entry!
```

**Errore**: `SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'XXX' for key 'PRIMARY'`

## Timeline Fix

### ✅ FATTO (27 Ottobre 2025)

1. ✅ Problema identificato e analizzato
2. ✅ Documentazione completa creata
3. ✅ Workaround implementato (LogsActivity disabilitato in BaseScheda)
4. ✅ Test workaround: edit funziona senza errore
5. ✅ Piano refactoring SchedaTrait creato

### 🔄 IN CORSO

6. 🔄 Deploy workaround in produzione
7. 🔄 Monitoraggio edit senza errori Duplicate Entry

### 📅 TODO (Sprint Futuri)

8. ⏳ Audit completo accessor SchedaTrait (15+ metodi)
9. ⏳ Refactoring accessor per rimuovere `$this->save()`
10. ⏳ Implementare Observer pattern per calcoli automatici
11. ⏳ Test regressione completi
12. ⏳ Riabilitare LogsActivity in BaseScheda
13. ⏳ Monitoraggio produzione post-riabilitazione

## Impatto Funzionale

### Cosa Funziona ✅

- ✅ Edit record IndennitaResponsabilita (nessun errore Duplicate Entry)
- ✅ Edit record Progressioni
- ✅ Edit altri modelli BaseScheda
- ✅ Activity Log per modelli NON-BaseScheda funziona normalmente

### Cosa NON Funziona ❌

- ❌ Storico modifiche per IndennitaResponsabilita (non viene tracciato)
- ❌ Audit trail per Progressioni (non viene tracciato)
- ❌ Activity log per modelli BaseScheda (temporaneamente disabilitato)

### Workaround Temporaneo

Per tracciare modifiche manualmente (se necessario):

```php
use Spatie\Activitylog\Models\Activity;

// Manualmente dopo save
activity()
    ->performedOn($record)
    ->causedBy(auth()->user())
    ->withProperties([
        'attributes' => $record->only(['stabi', 'coordinamento', /* ... */]),
        'old' => $record->getOriginal()
    ])
    ->log('updated');
```

## Documentazione Correlata

### Errori
- [Duplicate Entry Error](errori/duplicate-entry-accessor-save.md) - Analisi completa problema
- [Properties Vuote](troubleshooting/properties-vuote-activity-log.md) - Problema correlato

### Modelli
- [BaseScheda Activity Log](../../Ptv/docs/models/base-scheda-activity-log.md) - Status disabilitato
- [IndennitaResponsabilita Integration](../../IndennitaResponsabilita/docs/activity-log-integration.md)

### Refactoring
- [SchedaTrait Refactoring Plan](../../Sigma/docs/refactoring/scheda-trait-accessor-save-issue.md) - Piano dettagliato fix definitivo

## Contatti

**Responsabile**: TBD
**Team**: Backend
**Priority**: P0 (blocca Activity Log per modelli critici)
**ETA Fix Definitivo**: 6 settimane (3 sprint)

---

**Ultimo aggiornamento**: 27 Ottobre 2025
**Prossimo check**: Sprint Planning
