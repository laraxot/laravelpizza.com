# PHPStan Tests Corrections - Activity Module

**Data**: 2025-10-10  
**Livello PHPStan**: max  
**Errori Totali**: 353

## Pattern di Errori Identificati

### 1. Type Hints Errati nei Test (Alta Priorità)
**Problema**: PHPDoc con `@var \Illuminate\Database\Eloquent\Collection` invece del tipo corretto del Model.

**Esempio Errato**:
```php
/** @var \Illuminate\Database\Eloquent\Collection */
$user = User::factory()->create();
```

**Correzione**:
```php
/** @var User $user */
$user = User::factory()->create();
```

**File Corretti**:
- ✅ `ActivityEventSourcingTest.php` - Corretti tutti i type hints

### 2. Accesso a Proprietà su Collection (Alta Priorità)
**Problema**: Accesso diretto a proprietà su Collection senza verificare il tipo.

**Esempio Errato**:
```php
$activities = Activity::all();
expect($activities->first()->id)->toBe(1); // first() può essere null
```

**Correzione**:
```php
$activities = Activity::all();
$first = $activities->first();
expect($first)->toBeInstanceOf(Activity::class);
if ($first instanceof Activity) {
    expect($first->id)->toBe(1);
}
```

**File Corretti**:
- ✅ `ActivityEventSourcingTest.php` - Aggiunti controlli instanceof

### 3. UUID Type Casting (Media Priorità)
**Problema**: Passaggio di UuidInterface dove è richiesto string.

**Esempio Errato**:
```php
$uuid = Str::uuid();
Activity::forBatch($uuid)->get(); // Richiede string
```

**Correzione**:
```php
$uuid = Str::uuid();
Activity::forBatch((string) $uuid)->get();
```

**File Corretti**:
- ✅ `ActivityEventSourcingTest.php` - Aggiunti cast a string per UUID

### 4. Custom Pest Expectations Non Definite (Bassa Priorità)
**Problema**: Uso di metodi custom come `toBeActivity()` non definiti in Pest.php.

**File da Correggere**:
- ❌ `Unit/Models/ActivityTest.php`

### 5. Proprietà ReadOnly in Test (Bassa Priorità)
**Problema**: Tentativo di scrivere su proprietà readonly di oggetti anonimi.

**File da Correggere**:
- ❌ `Unit/Models/BaseModelTest.php`

## File Analizzati

### Feature Tests
1. ✅ `ActivityEventSourcingTest.php` - **CORRETTO**
2. ❌ `ActivityBusinessLogicTest.php` - Da analizzare
3. ❌ `ActivityIntegrationTest.php` - Da analizzare
4. ❌ `ActivityManagementTest.php` - Da analizzare
5. ❌ `BaseModelBusinessLogicPestTest.php` - Da analizzare
6. ❌ `SnapshotBusinessLogicTest.php` - Da analizzare
7. ❌ `StoredEventBusinessLogicTest.php` - Da analizzare

### Unit Tests
1. ❌ `EventSourcingBusinessLogicTest.php` - Da analizzare
2. ❌ `Filament/ResourceExtensionTest.php` - Da analizzare
3. ❌ `Listeners/LoginListenerTest.php` - Da analizzare
4. ❌ `Listeners/LogoutListenerTest.php` - Da analizzare
5. ❌ `Models/ActivityBusinessLogicTest.php` - Da analizzare
6. ❌ `Models/ActivityTest.php` - Custom expectations
7. ❌ `Models/BaseModelTest.php` - ReadOnly property
8. ❌ `Models/SnapshotBusinessLogicTest.php` - Da analizzare
9. ❌ `Models/StoredEventBusinessLogicTest.php` - Da analizzare

## Prossimi Passi

1. **Correggere Pest.php** - Definire custom expectations o rimuoverle
2. **Correggere ActivityIntegrationTest.php** - Simile a EventSourcingTest
3. **Correggere BaseModelTest.php** - Rimuovere uso di proprietà readonly
4. **Applicare pattern di correzione** agli altri file di test

## Note Tecniche

### Factory() Return Type
`Model::factory()->create()` restituisce sempre un'istanza del Model, NON una Collection.
`Model::factory()->count(N)->create()` restituisce una Collection.

### Pest Expectations Chain
Quando si usa `->first()` su una Collection, il risultato può essere `null`.
Sempre verificare con `instanceof` prima di accedere alle proprietà.

### UUID Handling
Larav `Str::uuid()` restituisce `UuidInterface`, ma molti metodi richiedono `string`.
Usare sempre `(string) $uuid` quando necessario.
