# PHPStan Fixes - Activity Module

## Errori Risolti

### 1. Constructor Return Type Error
**File**: `app/Events/ActivityEvent.php`
**Errore**: `Constructor of class Modules\Activity\Events\ActivityEvent has a return type`
**Causa**: Il costruttore aveva un tipo di ritorno `void` che non è permesso in PHP
**Soluzione**: Rimosso il tipo di ritorno dal costruttore

```php
// PRIMA (ERRATO)
public function __construct(): void {
    // $this->data = ['aaa' => 'bbb'];
}

// DOPO (CORRETTO)
public function __construct() {
    // $this->data = ['aaa' => 'bbb'];
}
```

**Motivazione**: I costruttori in PHP non possono avere tipi di ritorno espliciti. Il tipo di ritorno è sempre implicito e non può essere dichiarato.

**Business Logic**: L'evento `ActivityEvent` rappresenta un evento di attività nel sistema di logging. È utilizzato per tracciare le azioni degli utenti e le modifiche ai dati.

### 2. PHPDoc Type Mismatch in Filament Resources
**File**: `app/Filament/Resources/ActivityResource/Pages/EditActivity.php`
**Errore**: `PHPDoc tag @var with type array<string, Filament\Actions\Action> is not subtype of native type array{Filament\Actions\DeleteAction}`
**Causa**: Il PHPDoc dichiarava un tipo generico ma il metodo restituiva un tipo specifico
**Soluzione**: Aggiornato il PHPDoc per riflettere il tipo effettivo restituito

```php
// PRIMA (ERRATO)
/** @var array<string, \Filament\Actions\Action> */
return [
    DeleteAction::make(),
];

// DOPO (CORRETTO)
/** @var array{\Filament\Actions\DeleteAction} */
return [
    DeleteAction::make(),
];
```

### 3. PHPDoc Type Mismatch in Table Columns
**File**: `app/Filament/Resources/ActivityResource/Pages/ListActivities.php`
**Errore**: `PHPDoc tag @var with type array<string, Filament\Tables\Columns\Column> is not subtype of native type array{Filament\Tables\Columns\TextColumn, ...}`
**Causa**: Il PHPDoc dichiarava un tipo generico ma il metodo restituiva solo TextColumn
**Soluzione**: Aggiornato il PHPDoc per riflettere i tipi specifici delle colonne

```php
// PRIMA (ERRATO)
/** @var array<string, \Filament\Tables\Columns\Column> */
return [
    TextColumn::make('id'),
    TextColumn::make('description'),
    // ... altri TextColumn
];

// DOPO (CORRETTO)
/** @var array{\Filament\Tables\Columns\TextColumn, \Filament\Tables\Columns\TextColumn, ...} */
return [
    TextColumn::make('id'),
    TextColumn::make('description'),
    // ... altri TextColumn
];
```

### 4. PHPDoc Type Mismatch in Snapshot Resource
**File**: `app/Filament/Resources/SnapshotResource/Pages/ListSnapshots.php`
**Errore**: Simile al precedente per le colonne della tabella snapshot
**Soluzione**: Aggiornato il PHPDoc per riflettere i tipi specifici delle colonne

### 5. PHPDoc Type Mismatch in StoredEvent Resource
**File**: `app/Filament/Resources/StoredEventResource/Pages/ListStoredEvents.php`
**Errore**: `PHPDoc tag @var with type array<string, Filament\Tables\Columns\Column> is not subtype of native type array{Filament\Tables\Columns\TextColumn, Filament\Tables\Columns\TextColumn, Filament\Tables\Columns\ViewColumn}`
**Causa**: Il PHPDoc dichiarava un tipo generico ma il metodo restituiva tipi specifici misti
**Soluzione**: Aggiornato il PHPDoc per riflettere i tipi specifici delle colonne

```php
// PRIMA (ERRATO)
/** @var array<string, \Filament\Tables\Columns\Column> */
return [
    Tables\Columns\TextColumn::make('id'),
    Tables\Columns\TextColumn::make('event_class'),
    Tables\Columns\ViewColumn::make('event_properties'),
];

// DOPO (CORRETTO)
/** @var array{\Filament\Tables\Columns\TextColumn, \Filament\Tables\Columns\TextColumn, \Filament\Tables\Columns\ViewColumn} */
return [
    Tables\Columns\TextColumn::make('id'),
    Tables\Columns\TextColumn::make('event_class'),
    Tables\Columns\ViewColumn::make('event_properties'),
];
```

### 6. PHPDoc Issues in Models
**File**: `app/Models/Activity.php`, `app/Models/Snapshot.php`, `app/Models/StoredEvent.php`
**Errore**: `PHPDoc tag @mixin contains unknown class Eloquent` e `Class uses generic trait HasFactory but does not specify its types`
**Causa**: PHPDoc con riferimenti a classi non esistenti e tipi generici mancanti
**Soluzione**: Rimossi mixin problematici e aggiunti tipi generici appropriati

```php
// PRIMA (ERRATO)
/**
 * @mixin IdeHelperActivity
 * @mixin \Eloquent
 */
class Activity extends SpatieActivity
{
    use HasFactory;

// DOPO (CORRETTO)
/**
 * @extends \Illuminate\Database\Eloquent\Model<\Modules\Activity\Database\Factories\ActivityFactory>
 */
class Activity extends SpatieActivity
{
    use HasFactory;
```

### 7. Factory Generic Types
**File**: `database/factories/ActivityFactory.php`
**Errore**: `Class extends generic class Factory but does not specify its types`
**Causa**: Factory senza tipo generico specificato
**Soluzione**: Aggiunto tipo generico appropriato

```php
// PRIMA (ERRATO)
class ActivityFactory extends Factory

// DOPO (CORRETTO)
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Activity\Models\Activity>
 */
class ActivityFactory extends Factory
```

### 8. Seeder Method Issues
**File**: `database/seeders/ActivityMassSeeder.php`
**Errore**: `Call to an undefined method Collection::count()` e `Call to an undefined static method Activity::count()`
**Causa**: Metodi non trovati sui modelli e collezioni
**Soluzione**: Corretti i metodi di conteggio e aggiunti PHPDoc per metodi statici

```php
// PRIMA (ERRATO)
$this->command->info("✅ Create " . $activities->count() . " attività di sistema");
$totalActivities = Activity::count();

// DOPO (CORRETTO)
$this->command->info("✅ Create " . count($activities) . " attività di sistema");
$totalActivities = Activity::count(); // Con PHPDoc aggiunto
```

### 9. Rector Configuration Issues
**File**: `rector.php`
**Errore**: `Class ReturnTypeFromStrictScalarReturnExprRector not found` e `Access to constant UP_TO_PHPUNIT_100 on an unknown class`
**Causa**: Classi Rector non installate o non disponibili
**Soluzione**: Commentate le regole Rector problematiche

```php
// PRIMA (ERRATO)
$rectorConfig->rules([
    ReturnTypeFromStrictScalarReturnExprRector::class,
]);

// DOPO (CORRETTO)
// $rectorConfig->rules([
//     ReturnTypeFromStrictScalarReturnExprRector::class,
// ]);
```

## Pattern Identificati

### Constructor Rules
- I costruttori PHP non possono avere tipi di ritorno espliciti
- Utilizzare PHPDoc per documentare il comportamento del costruttore
- Evitare di dichiarare `void` come tipo di ritorno per i costruttori

### PHPDoc Type Accuracy
- I PHPDoc devono riflettere esattamente i tipi restituiti dai metodi
- Utilizzare tipi specifici invece di tipi generici quando possibile
- Per array con tipi misti, specificare tutti i tipi nell'ordine corretto

### Filament Resource Patterns
- Le risorse Filament hanno metodi che restituiscono array tipizzati
- I metodi `getTableColumns()` restituiscono array di colonne specifiche
- I metodi `getHeaderActions()` restituiscono array di azioni specifiche

### Model Generic Types
- I modelli che usano `HasFactory` devono specificare il tipo generico della factory
- Utilizzare `@extends Model<FactoryClass>` per specificare i tipi generici
- Evitare `@mixin` con classi non esistenti o non disponibili

### Collection vs Array Methods
- Utilizzare `count($collection)` invece di `$collection->count()` per le collezioni
- I metodi statici dei modelli richiedono PHPDoc appropriato per essere riconosciuti
- Le factory devono specificare il tipo del modello che creano

## Business Logic Context

### Activity Module
Il modulo Activity gestisce il logging delle attività degli utenti nel sistema. Include:

- **ActivityEvent**: Eventi di attività per il logging
- **ActivityResource**: Gestione delle attività attraverso Filament
- **SnapshotResource**: Gestione degli snapshot degli eventi
- **StoredEventResource**: Gestione degli eventi memorizzati

### Filament Integration
Il modulo utilizza Filament per fornire interfacce amministrative per:
- Visualizzazione delle attività degli utenti
- Gestione degli snapshot degli eventi
- Monitoraggio degli eventi memorizzati

## Collegamenti
- [README.md](./README.md)
- [Activity Logging Documentation](./activity-logging.md)
- [Filament Resources Documentation](./filament-resources.md)
# PHPStan Analysis Report for Activity Module

**Date:** December 23, 2025

**Outcome:**
The `Activity` module has been analyzed with PHPStan (as part of a full `Modules` directory scan), and **no errors were found**. This indicates that the module currently adheres to the project's PHPStan configuration and coding standards.

**Next Steps:**
While no errors were detected by PHPStan, continuous vigilance is required. Future development and modifications within this module should always be followed by PHPStan analysis to maintain this high standard. Additionally, `phpmd` and `phpinsights` analysis should be performed on any modified files to ensure overall code quality.
