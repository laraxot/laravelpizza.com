# BaseScheda - Configurazione Activity Log

## ⚠️ STATO ATTUALE: TEMPORANEAMENTE DISABILITATO

**Activity Log è DISABILITATO in BaseScheda fino a fix di SchedaTrait.**

### Perché Disabilitato?

**Errore**: `SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'XXX' for key 'PRIMARY'`

**Causa**: SchedaTrait ha 15+ accessor che chiamano `$this->save()` al loro interno. Quando Activity Log fa `$model->toArray()` per serializzare le properties, triggera questi accessor, che chiamano `save()`, causando errori di Duplicate Entry.

**Documentazione Completa**: [Duplicate Entry Error](../../Activity/docs/errori/duplicate-entry-accessor-save.md)

**Status**: Workaround temporaneo applicato - Activity Log disabilitato  
**Prossimo Step**: Refactoring SchedaTrait accessor  
**ETA Fix**: TBD

---

## Panoramica (Quando Sarà Riabilitato)

`BaseScheda` è la classe base per tutti i modelli di tipo "scheda" nel sistema (IndennitaResponsabilita, Progressioni, etc.). Include configurazione completa di Spatie Activity Log per tracciamento automatico modifiche.

## Business Logic

### Problema Risolto

**Requisito**: Tracciare TUTTE le modifiche su schede critiche per:
- Audit trail completo
- Compliance normativa
- Debug e troubleshooting
- Ripristino versioni precedenti

**Soluzione**: Configurazione centralizzata in BaseScheda con `LogsActivity` trait.

## Implementazione

### Trait e Configurazione

```php
<?php

namespace Modules\Ptv\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

abstract class BaseScheda extends BaseModel
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()  // ← Traccia TUTTI i campi fillable
            ->logOnlyDirty()  // ← Solo campi effettivamente modificati
            ->dontSubmitEmptyLogs();  // ← Non salvare log senza modifiche
    }
}
```

### Perché ->logAll() è Necessario

#### ❌ PRIMA (Properties Vuote)

```php
return LogOptions::defaults()
    // ->logAll() MANCANTE!
    ->logOnlyDirty();
```

**Risultato**:
```php
$activity->properties  // []  ← VUOTO!
```

**Problema**: `->logOnlyDirty()` da solo dice "traccia solo campi modificati", ma se non specifichi QUALI campi con `->logAll()` o `->logOnly()`, non traccia NULLA!

#### ✅ DOPO (Properties Complete)

```php
return LogOptions::defaults()
    ->logAll()  // ← AGGIUNTO!
    ->logOnlyDirty();
```

**Risultato**:
```php
$activity->properties  // ✅ PIENO!
// [
//     'attributes' => ['stabi' => 200, 'coordinamento' => 5],
//     'old' => ['stabi' => 100, 'coordinamento' => 3]
// ]
```

## Modelli che Ereditano

Tutti questi modelli ereditano automaticamente la configurazione:

- ✅ `Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita`
- ✅ `Modules\Progressioni\Models\Progressioni`
- ✅ `Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro`
- ✅ Altri modelli che estendono BaseScheda

**Vantaggio DRY**: Configurazione centralizzata, un solo punto di modifica!

## Override per Modelli Specifici

Se un modello ha esigenze diverse, può fare override:

```php
// Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logOnly([  // ← Solo campi specifici invece di logAll()
            'stabi',
            'coordinamento',
            'responsabilita',
            'complessita',
            'tot',
            'ha_diritto',
            'valutatore_id',
        ])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs()
        ->useLogName('indennita_responsabilita');  // ← Log name custom
}
```

## Opzioni Disponibili

### Metodi Principali

```php
LogOptions::defaults()
    ->logAll()  // Traccia TUTTI gli attributi
    ->logFillable()  // Traccia solo campi $fillable
    ->logOnly(['field1', 'field2'])  // Traccia campi specifici
    ->logExcept(['password', 'token'])  // Escludi campi sensibili
    ->logOnlyDirty()  // Solo campi modificati
    ->dontSubmitEmptyLogs()  // Non salvare se nessun cambiamento
    ->dontLogIfAttributesChangedOnly(['updated_at'])  // Ignora certi campi
    ->useLogName('custom_log')  // Nome log personalizzato
    ->setDescriptionForEvent('updated', 'record modificato');  // Descrizione custom
```

### Quando Usare Cosa

| Scenario | Configurazione |
|----------|----------------|
| **Audit completo** | `->logAll()` |
| **Solo campi business** | `->logOnly([campi])` |
| **Esclu di sensibili** | `->logAll()->logExcept(['password'])` |
| **Solo fillable** | `->logFillable()` |
| **Performance** | `->logOnly([pochi campi])` + `->logOnlyDirty()` |

## Eventi Tracciati

Per default vengono tracciati questi eventi Eloquent:

- ✅ `created` - Record creato
- ✅ `updated` - Record aggiornato
- ✅ `deleted` - Record eliminato

Eventi NON tracciati automaticamente:
- ❌ `retrieved` - Record letto
- ❌ `saving` - Prima del salvataggio
- ❌ `saved` - Dopo il salvataggio

## Performance

### Impatto Database

Con la configurazione attuale:

```php
->logAll()  // Traccia tutti i campi
->logOnlyDirty()  // MA solo quelli modificati
```

**Query generate**:
- 0 query extra su SELECT
- 1 INSERT nella tabella activity_log su UPDATE/CREATE/DELETE
- Minimo impatto performance

### Ottimizzazione

Se performance è critica:

```php
->logOnly(['campi_critici'])  // Solo campi essenziali
->logOnlyDirty()
->dontLogIfAttributesChangedOnly(['updated_at'])  // Ignora timestamp
```

## Problemi Comuni

### Properties Vuote

**Sintomo**: `$activity->properties` è `[]` vuoto

**Causa**: Manca `->logAll()` o `->logOnly()`

**Soluzione**: Vedere [Properties Vuote - Troubleshooting](../../Activity/docs/troubleshooting/properties-vuote-activity-log.md)

### Troppe Attività Create

**Sintomo**: Activity log piena di record inutili

**Causa**: Manca `->logOnlyDirty()` e `->dontSubmitEmptyLogs()`

**Soluzione**:
```php
->logAll()
->logOnlyDirty()  // ← AGGIUNGERE
->dontSubmitEmptyLogs()  // ← AGGIUNGERE
```

### Eventi Non Tracciati

**Sintomo**: Modifiche non appaiono in activity log

**Causa**: Eventi Eloquent disabilitati o `Model::withoutEvents()`

**Verifica**:
```php
// ❌ Questo NON crea activity
Model::withoutEvents(fn() => $model->update([...]));

// ✅ Questo crea activity
$model->update([...]);
```

### Accessor/Mutator che persistono valori derivati

Alcuni modelli che estendono `BaseScheda` (es. quelli che usano i trait di Sigma come `EnteMatrMutator`) calcolano valori derivati e li salvano in modo automatico dentro gli accessor/mutator, per motivi di performance (cache dei calcoli).

Per evitare interazioni pericolose con Activity Log:

- **usare sempre una guard su PK** negli accessor/mutator che salvano:

  ```php
  if ($this->getKey() == null) {
      return $value; // calcolato ma non persistito per record non ancora salvati
  }
  ```

- se il salvataggio avviene **durante** la lettura degli attributi (es. dentro `getXxxAttribute()`), usare in casi mirati `static::withoutEvents(...)` per evitare che gli eventi Eloquent innestino di nuovo Activity Log mentre sta serializzando il modello.

Questo pattern è documentato in:

- `Modules/Activity/docs/errori/attributerawvalues-null-firstorcreate.md`
- `Modules/Sigma/docs/troubleshooting.md`

## Testing

I test per BaseScheda Activity Log sono in:
- `Modules/Ptv/tests/Feature/Models/BaseSchedaActivityLogTest.php`

**Eseguire**:
```bash
cd laravel
php artisan test --filter=BaseSchedaActivityLog
```

## Collegamenti

### Documentazione Spatie
- [Spatie Activity Log - GitHub](https://github.com/spatie/laravel-activitylog)
- [Spatie Docs - Advanced Usage](https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/logging-model-events)
- [Spatie Docs - Customizing](https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/customizing-the-log-data)

### Documentazione Interna
- [Activity Module - README](../../Activity/docs/README.md)
- [Properties Vuote - Troubleshooting](../../Activity/docs/troubleshooting/properties-vuote-activity-log.md)
- [IndennitaResponsabilita - Activity Log](../../IndennitaResponsabilita/docs/activity-log-integration.md)

### Test
- [BaseSchedaActivityLogTest.php](../tests/Feature/Models/BaseSchedaActivityLogTest.php)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Versione Spatie**: 4.x  
**Pattern**: Configurazione centralizzata in BaseModel con ->logAll()  
**Status**: ✅ FUNZIONANTE e TESTATO

