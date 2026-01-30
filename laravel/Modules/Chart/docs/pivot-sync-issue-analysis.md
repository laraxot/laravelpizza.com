# Analisi Problema: sync() non aggiorna campi pivot

## Problema Identificato

Nel file `RegisterAction.php` alla riga 64, il codice:

```php
$res = $doctor->studios()->sync($studio, ['schedule' => $data['schedule']]);
```

**NON aggiorna** il campo `schedule` nella tabella pivot `studio_user`.

## Causa del Problema

### 1. Configurazione belongsToManyX

Il trait `belongsToManyX` nel file `RelationX.php` configura automaticamente la relazione con:

```php
->withPivot($pivotFields)
->withTimestamps();
```

Dove `$pivotFields` viene ottenuto da `$pivot->getFillable()` del modello pivot.

### 2. Modello Pivot DoctorStudio

Il modello `DoctorStudio` estende `StudioUser` che ha:

```php
protected $fillable = [
    'id',
    'user_id', 
    'studio_id',
    'schedule',
    'is_primary',
];
```

### 3. Problema con sync() e withPivot()

Il metodo `sync()` di Laravel ha un comportamento specifico:

- **Se la relazione è già configurata con `withPivot()`**, il secondo parametro di `sync()` viene **IGNORATO**
- Laravel utilizza solo i campi definiti in `withPivot()` per l'aggiornamento
- I campi aggiuntivi passati come secondo parametro vengono **SILENZIOSAMENTE IGNORATI**

## Soluzioni Possibili

### Soluzione 1: Rimuovere withPivot() dalla relazione (NON RACCOMANDATA)

```php
// NON FARE QUESTO - rompe la funzionalità esistente
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class)
        ->withoutPivot(); // Rimuove withPivot()
}
```

### Soluzione 2: Usare updateExistingPivot() (RACCOMANDATA)

```php
// Dopo la sincronizzazione, aggiorna esplicitamente il pivot
$res = $doctor->studios()->sync($studio);
$doctor->studios()->updateExistingPivot($studio->id, ['schedule' => $data['schedule']]);
```

### Soluzione 3: Usare attach() con detach() (ALTERNATIVA)

```php
// Rimuovi la relazione esistente
$doctor->studios()->detach($studio);

// Aggiungi con i dati pivot
$doctor->studios()->attach($studio, ['schedule' => $data['schedule']]);
```

### Soluzione 4: Modificare la relazione per essere più specifica (MIGLIORE)

```php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class)
        ->withPivot(['schedule', 'is_primary']) // Esplicita solo i campi necessari
        ->withTimestamps();
}
```

## Raccomandazione Implementativa

### Per RegisterAction.php

```php
// Opzione A: Usa updateExistingPivot()
$res = $doctor->studios()->sync($studio);
if (isset($data['schedule'])) {
    $doctor->studios()->updateExistingPivot($studio->id, [
        'schedule' => $data['schedule']
    ]);
}

// Opzione B: Usa attach() con controllo esistenza
if ($doctor->studios()->where('studio_id', $studio->id)->exists()) {
    $doctor->studios()->updateExistingPivot($studio->id, [
        'schedule' => $data['schedule']
    ]);
} else {
    $doctor->studios()->attach($studio, [
        'schedule' => $data['schedule']
    ]);
}
```

## Verifica della Soluzione

Per verificare che la soluzione funzioni:

```php
// Debug dopo l'aggiornamento
$pivotRecord = $doctor->studios()
    ->where('studio_id', $studio->id)
    ->first()
    ->pivot;

dd([
    'schedule_updated' => $pivotRecord->schedule,
    'expected_schedule' => $data['schedule'],
    'pivot_id' => $pivotRecord->id
]);
```

## Note Importanti

1. **Cross-Database**: La relazione attraversa database diversi (user ↔ <nome progetto>_data)
2. **belongsToManyX**: Gestisce automaticamente la configurazione cross-database
3. **withPivot()**: Definisce i campi disponibili per l'aggiornamento
4. **sync()**: Ignora campi non definiti in withPivot()

## Collegamenti Correlati

- [Modules/<nome progetto>/app/Actions/Doctor/RegisterAction.php](../../laravel/Modules/<nome progetto>/app/Actions/Doctor/RegisterAction.php)
- [Modules/<nome progetto>/app/Models/Doctor.php](../../laravel/Modules/<nome progetto>/app/Models/Doctor.php)
- [Modules/<nome progetto>/app/Models/DoctorStudio.php](../../laravel/Modules/<nome progetto>/app/Models/DoctorStudio.php)
- [Modules/Xot/app/Models/Traits/RelationX.php](../../laravel/Modules/Xot/app/Models/Traits/RelationX.php)

*Ultimo aggiornamento: 2025-01-06* 