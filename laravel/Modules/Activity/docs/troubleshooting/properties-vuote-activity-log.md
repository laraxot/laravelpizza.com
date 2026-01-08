# Troubleshooting: Properties Vuote in Activity Log

## Problema

Le attività vengono create correttamente (description='updated', subject registrato), ma le **properties sono VUOTE** - non vengono salvati i dati dei campi modificati.

## Sintomo

```php
$activity = Activity::latest()->first();
echo $activity->description;  // "updated" ✅ OK
echo $activity->subject_type;  // "Modules\..." ✅ OK
print_r($activity->properties);  // [] ❌ VUOTO!
```

**Risultato**: Non puoi vedere QUALI campi sono stati modificati e quali erano i valori vecchi/nuovi.

## Causa Radice

### Configurazione Incompleta in `getActivitylogOptions()`

Il trait `LogsActivity` richiede configurazione esplicita di **QUALI campi tracciare**.

#### ❌ Configurazione ERRATA (Properties Vuote)

```php
// Modules/Ptv/app/Models/BaseScheda.php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        // ->logOnly(['field1', 'field2'])  ← COMMENTATO!
        ->logOnlyDirty();  // ← Da solo NON basta!
}
```

**Problema**: `->logOnlyDirty()` dice "traccia solo campi modificati", ma se non specifichi QUALI campi con `->logOnly()` o `->logAll()`, non traccia NULLA!

#### ✅ Configurazione CORRETTA (Properties Complete)

```php
// Modules/Ptv/app/Models/BaseScheda.php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logAll()  // ← Traccia TUTTI i campi fillable
        ->logOnlyDirty()  // ← Solo campi modificati
        ->dontSubmitEmptyLogs();  // ← Non salvare log senza modifiche
}
```

O se vuoi tracciare solo campi specifici:

```php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logOnly(['stabi', 'coordinamento', 'responsabilita', 'tot'])  // ← Campi specifici
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

## Analisi Approfondita

### Comportamento LogOptions::defaults()

Secondo [documentazione Spatie Activity Log](https://github.com/spatie/laravel-activitylog):

```php
LogOptions::defaults()
```

Equivale a:

```php
return LogOptions::make()
    ->logFillable()  // ← Traccia campi fillable MA solo se esplicitato!
    ->logOnlyDirty()  // ← Solo campi dirty
    ->dontSubmitEmptyLogs();  // ← Non salvare log vuoti
```

**MA** il problema è che `defaults()` **NON attiva automaticamente** il logging di tutti i campi!

### Cosa Serve per Tracciare Campi

Per tracciare i cambiamenti effettivi serve UNO di questi:

1. **`->logAll()`**: Traccia TUTTI gli attributi
2. **`->logFillable()`**: Traccia solo campi $fillable
3. **`->logOnly(['field1', 'field2'])`**: Traccia campi specifici

**SENZA** uno di questi, le properties saranno vuote anche con `->logOnlyDirty()`.

### Spiegazione Tecnica

```php
// Scenario attuale:
->logOnlyDirty()  // "Traccia solo campi modificati"

// MA quali campi? Nessuno specificato!
// Risultato: [] (properties vuote)

// Fix:
->logAll()  // "Traccia tutti i campi"
->logOnlyDirty()  // "Ma solo quelli modificati"

// Risultato: Properties con old/attributes complete!
```

## Soluzione Step-by-Step

### Soluzione 1: Tracciare Tutti i Campi (Raccomandato per Audit)

```php
// Modules/Ptv/app/Models/BaseScheda.php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logAll()  // ← AGGIUNGERE QUESTO
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

**Pro**:
- ✅ Traccia tutte le modifiche
- ✅ Audit trail completo
- ✅ Facile debug

**Contro**:
- ⚠️ Più dati salvati (ma solo campi dirty)
- ⚠️ Potrebbe includere campi sensibili

### Soluzione 2: Tracciare Solo Campi Business-Critical

```php
// Modules/Ptv/app/Models/BaseScheda.php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logOnly([
            'stabi',
            'repar',
            'anno',
            'coordinamento',
            'responsabilita',
            'complessita',
            'tot',
            'ha_diritto',
            'valutatore_id',
        ])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

**Pro**:
- ✅ Traccia solo campi rilevanti
- ✅ Meno dati salvati
- ✅ Focus su business logic

**Contro**:
- ⚠️ Campi non listati non vengono tracciati

### Soluzione 3: Override in IndennitaResponsabilita

Se BaseScheda è condivisa da molti modelli e non vuoi modificarla:

```php
// Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php
use Spatie\Activitylog\LogOptions;

class IndennitaResponsabilita extends BaseScheda
{
    /**
     * Override configurazione Activity Log.
     *
     * Specifica esplicitamente i campi da tracciare per questo modello.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'stabi',
                'repar',
                'coordinamento',
                'responsabilita',
                'complessita',
                'tot',
                'ha_diritto',
                'valutatore_id',
                'valore_economico_attribuito',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('indennita_responsabilita');
    }
}
```

## Test di Verifica

### Test Manuale

```bash
cd /var/www/html/ptvx/laravel
php artisan tinker
```

```php
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Spatie\Activitylog\Models\Activity;

// Modifica record
$record = IndennitaResponsabilita::first();
$record->stabi = 999;
$record->coordinamento = 5;
$record->save();

// Verifica activity
$activity = Activity::latest()->first();
print_r($activity->properties->toArray());

// DEVE mostrare:
// [
//     'attributes' => ['stabi' => 999, 'coordinamento' => 5, ...],
//     'old' => ['stabi' => 510, 'coordinamento' => 3, ...]
// ]
```

### Test Automatico Pest

```php
// tests/Feature/Models/IndennitaResponsabilitaActivityLogTest.php

test('activity log saves field changes in properties', function () {
    $record = IndennitaResponsabilita::factory()->create([
        'stabi' => 100,
        'coordinamento' => 1,
    ]);

    $record->update([
        'stabi' => 200,
        'coordinamento' => 2,
    ]);

    $activity = Activity::latest()->first();

    expect($activity->properties)
        ->not->toBeEmpty('Properties non devono essere vuote!')
        ->toHaveKey('attributes')
        ->toHaveKey('old');

    expect($activity->properties['attributes'])
        ->toHaveKey('stabi')
        ->toHaveKey('coordinamento');

    expect($activity->properties['attributes']['stabi'])->toBe(200);
    expect($activity->properties['old']['stabi'])->toBe(100);
});
```

## Problemi Correlati

### Connessioni Database Multiple

**Attenzione**: Il modello usa `protected $connection = 'indennita_responsabilita'` mentre Activity Log usa connessione `'activity'`.

**Verificare** che entrambe le connessioni siano configurate correttamente:

```php
// config/database.php
'connections' => [
    'activity' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST_ACTIVITY', '127.0.0.1'),
        // ...
    ],
    'indennita_responsabilita' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST_INDENNITA', '127.0.0.1'),
        // ...
    ],
],
```

### Eventi Eloquent Silenzati

Se usi `Model::withoutEvents()` o disabiliti observers, Activity Log non funzionerà:

```php
// ❌ Questo NON crea activity
IndennitaResponsabilita::withoutEvents(function () {
    $record->update(['stabi' => 999]);
});

// ✅ Questo crea activity
$record->update(['stabi' => 999]);
```

## Best Practice

### 1. Specifica Sempre Campi da Tracciare

```php
// ✅ SEMPRE specificare logOnly() o logAll()
->logAll()  // Tutti i campi
// OPPURE
->logOnly(['field1', 'field2'])  // Campi specifici
```

### 2. Usa logOnlyDirty per Performance

```php
->logOnlyDirty()  // Traccia solo campi effettivamente modificati
```

### 3. Non Salvare Log Vuoti

```php
->dontSubmitEmptyLogs()  // Non salvare se nessun campo è cambiato
```

### 4. Escludi Campi Sensibili

```php
->logAll()
->logExcept(['password', 'remember_token', 'api_token'])
```

### 5. Usa Log Name per Categorizzazione

```php
->useLogName('indennita_responsabilita')  // Categorizza i log
```

## Collegamenti

### Documentazione Spatie
- [Spatie Activity Log - GitHub](https://github.com/spatie/laravel-activitylog)
- [Spatie Docs - Logging Options](https://spatie.be/docs/laravel-activitylog/v4/advanced-usage/logging-model-events)

### Documentazione Interna
- [Activity Module - README](../README.md)
- [BaseScheda Configuration](../../Ptv/docs/models/base-scheda-activity-log.md)
- [IndennitaResponsabilita Integration](../../IndennitaResponsabilita/docs/activity-log-integration.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Severità**: Media (funziona ma properties vuote)  
**Soluzione**: Aggiungere `->logAll()` o `->logOnly()` in getActivitylogOptions()


