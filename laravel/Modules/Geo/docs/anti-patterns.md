# Anti-Pattern Comuni in Laraxot

## Panoramica

Questo documento cataloga gli anti-pattern più comuni identificati nel progetto e fornisce soluzioni corrette per evitarli.

## 1. Uso di property_exists con Modelli Laravel

### ❌ Anti-Pattern

```php
// MAI fare questo con modelli Eloquent
if (property_exists($model, 'email')) {
    $email = $model->email;
}

// MAI fare questo con oggetti generici
if (property_exists($object, 'value')) {
    $value = $object->value;
}
```

### ✅ Soluzione Corretta

Utilizzare le azioni di cast sicure del modulo Xot:

```php
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;
use Modules\Xot\Actions\Cast\SafeObjectCastAction;

// Per modelli Eloquent
if (app(SafeEloquentCastAction::class)->hasAttribute($model, 'email')) {
    $email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');
}

// Per oggetti generici
if (app(SafeObjectCastAction::class)->hasProperty($object, 'value')) {
    $value = app(SafeObjectCastAction::class)->getStringProperty($object, 'value', '');
}
```

### Motivazione

- `property_exists()` è una funzione PHP generica che non conosce l'architettura Laravel
- Può dare falsi positivi con proprietà dinamiche di Eloquent
- È meno performante e meno leggibile
- Non segue i principi DRY e KISS
- Può causare errori di tipo e comportamenti imprevedibili

### Collegamenti

- [Documentazione Azioni Cast](../../laravel/Modules/Xot/docs/cast-actions.md)
- [SafeEloquentCastAction](../../laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php)
- [SafeObjectCastAction](../../laravel/Modules/Xot/app/Actions/Cast/SafeObjectCastAction.php)

## 2. Estensione Diretta di Classi Filament

### ❌ Anti-Pattern

```php
// MAI estendere direttamente classi Filament
use Filament\Resources\Resource;

class MyResource extends Resource
{
    // ...
}
```

### ✅ Soluzione Corretta

Estendere sempre le classi base Xot:

```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    // ...
}
```

### Motivazione

- Le classi base Xot forniscono funzionalità comuni e configurazioni standard
- Mantiene coerenza architetturale nel progetto
- Evita duplicazione di codice e configurazioni
- Rispetta la separazione delle responsabilità

## 3. Stringhe Hardcoded nelle Interfacce

### ❌ Anti-Pattern

```php
// MAI usare stringhe hardcoded
TextInput::make('email')
    ->label('Email')
    ->placeholder('Inserisci la tua email');
```

### ✅ Soluzione Corretta

Utilizzare sempre i file di traduzione:

```php
// Il LangServiceProvider gestisce automaticamente le traduzioni
TextInput::make('email');
```

### Motivazione

- Centralizza la gestione delle traduzioni
- Facilita la localizzazione
- Mantiene coerenza nell'interfaccia utente
- Rispetta le convenzioni Laravel

## 4. Namespace con Segmento 'App'

### ❌ Anti-Pattern

```php
// MAI includere 'App' nei namespace
namespace Modules\ModuleName\App\Models;
namespace Modules\ModuleName\App\Http\Controllers;
```

### ✅ Soluzione Corretta

```php
// Namespace corretto
namespace Modules\ModuleName\Models;
namespace Modules\ModuleName\Http\Controllers;
```

### Motivazione

- La configurazione PSR-4 mappa `Modules\ModuleName\` direttamente alla cartella `app/`
- Evita confusione e duplicazione
- Mantiene coerenza con la struttura del progetto
- Rispetta le convenzioni Laravel

## 5. Metodo down() nelle Migrazioni

### ❌ Anti-Pattern

```php
// MAI implementare down() in migrazioni che estendono XotBaseMigration
public function down(): void
{
    Schema::dropIfExists($this->table_name);
}
```

### ✅ Soluzione Corretta

```php
// La gestione del rollback è centralizzata in XotBaseMigration
return new class extends XotBaseMigration {
    public function up(): void
    {
        // Implementazione
    }
    // NIENTE metodo down()
};
```

### Motivazione

- Evita duplicazione di logica
- Mantiene coerenza nel comportamento delle migrazioni
- Centralizza la gestione del rollback
- Previene errori di configurazione

## 6. Uso di mixed senza Necessità

### ❌ Anti-Pattern

```php
// MAI usare mixed quando è possibile essere più specifici
public function processData(mixed $data): mixed
{
    // ...
}
```

### ✅ Soluzione Corretta

```php
// Utilizzare tipi specifici o union types
public function processData(array|string $data): string
{
    // ...
}
```

### Motivazione

- Migliora la type safety
- Facilita l'analisi statica con PHPStan
- Rende il codice più leggibile e manutenibile
- Previene errori runtime

## 7. Ignorare Errori PHPStan

### ❌ Anti-Pattern

```php
// MAI ignorare errori PHPStan senza documentare il motivo
/** @phpstan-ignore-next-line */
$value = $object->undefinedProperty;
```

### ✅ Soluzione Corretta

```php
// Documentare sempre il motivo dell'ignoramento
/** @phpstan-ignore-next-line - Proprietà dinamica gestita da magic methods */
$value = $object->dynamicProperty;
```

### Motivazione

- Mantiene la qualità del codice
- Facilita la manutenzione
- Previene l'accumulo di debito tecnico
- Rispetta i principi di clean code

## Best Practices Generali

1. **Sempre utilizzare le classi base Xot** quando disponibili
2. **Mai usare property_exists** con modelli Laravel
3. **Utilizzare sempre i file di traduzione** per le interfacce
4. **Rispettare i namespace** senza segmenti 'App'
5. **Implementare sempre tipi specifici** invece di mixed
6. **Documentare sempre le eccezioni** alle regole
7. **Eseguire PHPStan regolarmente** per mantenere la qualità

## Controlli Automatici

Eseguire regolarmente questi controlli:

```bash
# Analisi statica completa
./vendor/bin/phpstan analyse --level=9

# Controllo convenzioni di codice
./vendor/bin/pint --test

# Test automatici
php artisan test
```

## Collegamenti

- [Regole Cursor](../../.cursor/rules)
- [Regole Windsurf](../../.windsurf/rules)
- [Documentazione Moduli](../../laravel/Modules/)
- [PHPStan Configuration](../../laravel/phpstan.neon)
