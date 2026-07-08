# Struttura dei Moduli in PTVX

Questo documento definisce le linee guida ufficiali per la struttura dei moduli all'interno del framework PTVX.

## Service Provider

### Convenzioni Base

Ogni modulo deve avere un ServiceProvider che estende `XotBaseServiceProvider`. Questo provider è responsabile della registrazione delle risorse del modulo (routes, views, translations, etc.) nell'applicazione.

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class NomeModuloServiceProvider extends XotBaseServiceProvider {
    // Implementazione
}
```

### Proprietà Obbligatorie

Il ServiceProvider deve definire le seguenti proprietà:

1. **public string $name**: Nome del modulo in formato PascalCase/CamelCase con prima lettera maiuscola (NON $module_name)
   ```php
   public string $name = 'NomeModulo';
   ```
   
   > **IMPORTANTE**: La stessa proprietà deve essere definita anche nel `RouteServiceProvider` del modulo

2. **protected string $module_dir**: Directory del modulo (default: `__DIR__`)
   ```php
   protected string $module_dir = __DIR__;
   ```

3. **protected string $module_ns**: Namespace del modulo (default: `__NAMESPACE__`)
   ```php
   protected string $module_ns = __NAMESPACE__;
   ```

### Proprietà Opzionali

1. **public string $nameLower**: Versione minuscola del nome del modulo (se non definita, viene generata automaticamente da $name)

### Metodi Personalizzabili

I seguenti metodi possono essere sovrascritti per personalizzare il comportamento del ServiceProvider:

- `register()`: Registra i servizi del modulo nel container
- `registerTranslations()`: Registra le traduzioni
- `registerConfig()`: Registra le configurazioni
- `registerViews()`: Registra le viste
- `registerFactories()`: Registra le factories per i modelli
- `registerCommands()`: Registra i comandi Artisan
- `registerLivewireComponents()`: Registra i componenti Livewire

## Errori Comuni

### Nome del Modulo Mancante o Errato

Se viene mostrato l'errore `name is empty on [Modules\NomeModulo\Providers\NomeModuloServiceProvider]`, significa che:

1. La proprietà `$name` non è stata definita nel ServiceProvider
2. È stata utilizzata `$module_name` invece di `$name`

**Correzione**:
```php
// ERRATO
public string $module_name = 'nomeModulo';
// ERRATO
public string $name = 'nomemodulo';

// CORRETTO
public string $name = 'NomeModulo';
```

## Esempio Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class BlogServiceProvider extends XotBaseServiceProvider {
    public string $name = 'Blog';
    
    protected string $module_dir = __DIR__;
    
    protected string $module_ns = __NAMESPACE__;
    
    // Metodi personalizzati se necessario
    public function registerConfig(): void
    {
        // Configurazione personalizzata
        parent::registerConfig();
    }
}
```
