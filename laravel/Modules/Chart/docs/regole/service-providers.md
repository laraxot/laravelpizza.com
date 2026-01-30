# Regole per Service Providers in Base

Tutti i ServiceProvider dei moduli in Base **DEVONO** estendere `Modules\Xot\Providers\XotBaseServiceProvider` invece di `Illuminate\Support\ServiceProvider`.

### ❌ NON utilizzare:

```php
use Illuminate\Support\ServiceProvider;

class ModuleNameServiceProvider extends ServiceProvider
{
    // ...
}
```

### ✅ Utilizzare invece:

```php
use Modules\Xot\Providers\XotBaseServiceProvider;

class ModuleNameServiceProvider extends XotBaseServiceProvider
{
    // ...
}
```

## Proprietà Obbligatorie

Ogni ServiceProvider di modulo deve definire le seguenti proprietà:

```php
public string $name = 'ModuleName';        // Nome del modulo
public string $nameLower = 'modulename';   // Nome del modulo in minuscolo
protected string $module_dir = __DIR__;    // Directory del modulo
protected string $module_ns = __NAMESPACE__; // Namespace del modulo
```

## Visibilità dei Metodi

I metodi che sovrascrivi da XotBaseServiceProvider devono mantenere la stessa visibilità o essere meno restrittivi:

### ❌ NON utilizzare:

```php
protected function registerCommands(): void
{
    // ...
}
```

### ✅ Utilizzare invece:

```php
public function registerCommands(): void
{
    parent::registerCommands();
    // ...
}
```

## Metodi Comuni da Implementare

```php
// Inizializzazione del modulo
public function boot(): void
{
    parent::boot();
    // Aggiungere inizializzazioni specifiche
}

// Registrazione di servizi
public function register(): void
{
    parent::register();
    // Registrare servizi specifici
}

// Registrazione di comandi
public function registerCommands(): void
{
    parent::registerCommands();
    $this->commands([
        // CommandClass::class,
    ]);
}
```

## Ordine di Esecuzione

1. `register()`: Chiamato prima per registrare servizi e dipendenze
2. `boot()`: Chiamato dopo per configurare servizi già registrati

## Registrazione di Provider Aggiuntivi

Per registrare provider aggiuntivi, utilizzare:

```php
public function register(): void
{
    parent::register();
    
    $this->app->register(RouteServiceProvider::class);
    $this->app->register(EventServiceProvider::class);
}
```

Ultima modifica: 01/04/2025
