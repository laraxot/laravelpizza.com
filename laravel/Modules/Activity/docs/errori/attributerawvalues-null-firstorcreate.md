# Errore: Attempt to read property "attributeRawValues" on null durante firstOrCreate

## Problema

Quando si utilizza `firstOrCreate()` su un modello che usa il trait `LogsActivity` di Spatie, si verifica l'errore:

```
ErrorException - Internal Server Error
Attempt to read property "attributeRawValues" on null
```

### Stack Trace

L'errore si verifica in:
- `vendor/spatie/laravel-activitylog/src/Traits/LogsActivity.php:352`
- Durante l'esecuzione di `firstOrCreate()` su un modello che estende `BaseScheda`

### Causa Radice

Il trait `LogsActivity` cerca di accedere alla proprietà `attributeRawValues` durante la creazione di un nuovo modello con `firstOrCreate()`. Tuttavia, durante la fase di creazione iniziale, questa proprietà è `null` perché il modello non è ancora stato completamente inizializzato.

**Sequenza del problema**:
1. `firstOrCreate()` viene chiamato con dati array
2. Il modello viene istanziato per verificare se esiste già
3. Se non esiste, viene creato un nuovo modello
4. Durante la creazione, `LogsActivity` tenta di accedere a `attributeRawValues`
5. `attributeRawValues` è `null` perché il modello non è ancora stato salvato
6. Errore: "Attempt to read property 'attributeRawValues' on null"

## Soluzione

Disabilitare temporaneamente gli eventi Eloquent (e quindi il logging di Activity Log) durante `firstOrCreate()` usando `withoutEvents()`:

```php
// ❌ ERRATO - Causa errore
$model::firstOrCreate($data);

// ✅ CORRETTO - Disabilita temporaneamente LogsActivity
$model::withoutEvents(function () use ($model, $data): void {
    $model::firstOrCreate($data);
});
```

### Implementazione in PopulateByYearAction

```php
foreach ($adds as $add) {
    if (! is_array($add)) {
        continue;
    }
    /** @var array<string, mixed> $addData */
    $addData = $add;
    $addData[$fieldName] = $year;
    
    // Disabilita temporaneamente LogsActivity durante firstOrCreate per evitare
    // errore "Attempt to read property 'attributeRawValues' on null"
    // Il trait LogsActivity cerca di accedere a attributeRawValues che è null
    // durante la creazione di un nuovo modello con firstOrCreate()
    $validatedModelClass::withoutEvents(function () use ($validatedModelClass, $addData): void {
        $validatedModelClass::firstOrCreate($addData);
    });
}
```

## Quando Usare withoutEvents()

### ✅ DO - Usare withoutEvents() per:

1. **Operazioni batch con firstOrCreate()**
   ```php
   Model::withoutEvents(function () use ($data): void {
       Model::firstOrCreate($data);
   });
   ```

2. **Creazioni multiple in loop**
   ```php
   foreach ($items as $item) {
       Model::withoutEvents(function () use ($item): void {
           Model::firstOrCreate($item);
       });
   }
   ```

3. **Migrazioni e seeding**
   ```php
   Model::withoutEvents(function (): void {
       Model::factory()->count(100)->create();
   });
   ```

### ❌ DON'T - NON usare withoutEvents() per:

1. **Operazioni normali di creazione/update**
   ```php
   // ❌ NON fare questo per operazioni normali
   Model::withoutEvents(function (): void {
       $model->update(['field' => 'value']);
   });
   ```

2. **Quando serve tracciare le modifiche**
   ```php
   // ❌ NON disabilitare se serve audit trail
   Model::withoutEvents(function (): void {
       $model->save(); // Perderà il log!
   });
   ```

## Pattern Alternativi

### Pattern 1: Usare first() + create() separatamente

```php
$model = Model::first($attributes);
if ($model === null) {
    Model::withoutEvents(function () use ($attributes, $values): void {
        Model::create(array_merge($attributes, $values));
    });
}
```

### Pattern 2: Usare updateOrCreate() invece di firstOrCreate()

```php
// updateOrCreate() gestisce meglio LogsActivity
Model::updateOrCreate($attributes, $values);
```

### Pattern 3: Disabilitare solo Activity Log (se disponibile)

```php
// Se il modello ha metodo disableLogging()
$model->disableLogging();
$model->firstOrCreate($data);
$model->enableLogging();
```

## Modelli Affetti

Questo problema si verifica con tutti i modelli che:
- Estendono `BaseScheda` (che usa `LogsActivity`)
- Utilizzano `firstOrCreate()` per creare nuovi record
- Hanno accessor che chiamano `update()` o `save()` (es. `getValutatoreIdAttribute()`)

**Modelli noti**:
- `Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita`
- `Modules\Progressioni\Models\Progressioni`
- `Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro`
- Altri modelli che estendono `BaseScheda`

## Caso Particolare: Accessor che Triggerano Update

Quando un accessor (es. `getValutatoreIdAttribute()`) chiama `update()` internamente, l'accesso all'attributo durante operazioni Collection (es. `whereNotIn()`) può causare lo stesso errore.

### Soluzione: Usare getAttribute() per Valori Raw

```php
// ❌ ERRATO - Triggera l'accessor che chiama update()
$rows_invalid = $rows->whereNotIn('valutatore_id', $valutatore_ids);

// ✅ CORRETTO - Usa getAttribute() per accedere al valore raw
$rows_invalid = $rows->filter(function (Model $row) use ($valutatore_ids): bool {
    $valutatoreId = $row->getAttribute('valutatore_id'); // Valore raw, non triggera accessor
    return ! in_array($valutatoreId, $valutatore_ids, true);
});
```

**Implementazione in FixValutatoreIdByAnno**:
```php
// Usa getAttribute() per accedere al valore raw invece dell'accessor
// per evitare che getValutatoreIdAttribute() triggeri update() che causa
// errore "Attempt to read property 'attributeRawValues' on null" in LogsActivity
$rows_invalid = $rows->filter(function (Model $row) use ($valutatore_ids): bool {
    // Usa getAttribute() per accedere al valore raw senza triggerare l'accessor
    $valutatoreId = $row->getAttribute('valutatore_id');
    return ! in_array($valutatoreId, $valutatore_ids, true);
});
```

## Test di Verifica

### Test Manuale

```bash
cd /var/www/html/ptvx/laravel
php artisan tinker
```

```php
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

// ❌ Questo causerà errore
try {
    IndennitaResponsabilita::firstOrCreate([
        'ente' => 90,
        'matr' => 12345,
        'anno' => 2025,
    ]);
} catch (\Exception $e) {
    echo $e->getMessage(); // "Attempt to read property 'attributeRawValues' on null"
}

// ✅ Questo funziona
IndennitaResponsabilita::withoutEvents(function (): void {
    IndennitaResponsabilita::firstOrCreate([
        'ente' => 90,
        'matr' => 12345,
        'anno' => 2025,
    ]);
});
```

## Note Importanti

1. **Performance**: `withoutEvents()` disabilita TUTTI gli eventi Eloquent, non solo Activity Log
2. **Audit Trail**: Le operazioni dentro `withoutEvents()` NON vengono tracciate
3. **Uso Consapevole**: Usare solo quando necessario per operazioni batch o migrazioni
4. **Alternativa**: Considerare `updateOrCreate()` che gestisce meglio LogsActivity

## Collegamenti

- [BaseScheda Activity Log Configuration](../../Ptv/docs/models/base-scheda-activity-log.md)
- [Activity Log Troubleshooting](../troubleshooting/properties-vuote-activity-log.md)
- [PopulateByYearAction](../../Ptv/app/Actions/PopulateByYearAction.php)

---

**Ultimo aggiornamento**: 19 Novembre 2025  
**Severità**: Alta (blocca operazioni batch)  
**Soluzione**: Usare `withoutEvents()` durante `firstOrCreate()`

