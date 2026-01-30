# Implementazione di un ServiceProvider con XotBaseServiceProvider

## Struttura Base
```php
<?php

namespace Modules\YourModule\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class YourModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'YourModule';

    public function boot(): void
    {
        parent::boot();
        // Aggiungi qui la logica specifica del modulo
    }
}
```

## Requisiti Fondamentali

### 1. Nome del Modulo
```php
public string $name = 'YourModule';
```
- DEVE essere impostato
- DEVE corrispondere al nome della directory del modulo
- Viene utilizzato per:
  - Namespace dei componenti
  - Prefissi delle icone
  - Percorsi delle risorse

### 2. Metodi del Ciclo di Vita
```php
public function boot(): void
{
    parent::boot();
    // Logica specifica del modulo
}

public function register(): void
{
    parent::register();
    // Logica specifica del modulo
}
```
- Chiamare SEMPRE i metodi parent
- Aggiungere la logica specifica dopo la chiamata parent

## Cosa NON Fare

### 1. Non Reimplementare Metodi Base
❌ NON reimplementare questi metodi:
```php
protected function registerConfig(): void
protected function registerViews(): void
protected function registerTranslations(): void
protected function registerCommands(): void
```
Sono già implementati in XotBaseServiceProvider.

### 2. Non Modificare la Struttura delle Directory
❌ NON modificare:
- `resources/views`
- `lang`
- `config`
- `Database/Migrations`
- `Routes`

### 3. Non Modificare i Namespace
❌ NON modificare:
- Namespace base del modulo
- Namespace dei componenti
- Namespace delle viste

## Cosa Fare

### 1. Aggiungere Risorse Filament
```php
protected function registerResources(): void
{
    if (class_exists(Filament::class)) {
        Filament::registerResources([
            YourResource::class,
        ]);
    }
}
```

### 2. Aggiungere Middleware
```php
protected function registerMiddleware(): void
{
    $this->app['router']->aliasMiddleware('your-middleware', YourMiddleware::class);
}
```

### 3. Aggiungere Eventi
```php
protected function registerEvents(): void
{
    $this->app['events']->listen(YourEvent::class, YourListener::class);
}
```

## Best Practices

### 1. Organizzazione del Codice
```php
class YourModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'YourModule';

    public function boot(): void
    {
        parent::boot();
        $this->registerResources();
        $this->registerMiddleware();
        $this->registerEvents();
    }

    protected function registerResources(): void
    {
        // Registrazione risorse
    }

    protected function registerMiddleware(): void
    {
        // Registrazione middleware
    }

    protected function registerEvents(): void
    {
        // Registrazione eventi
    }
}
```

### 2. Gestione delle Dipendenze
- Dichiarare le dipendenze nel `composer.json`
- Utilizzare il namespace corretto per le importazioni
- Verificare la presenza delle classi prima di utilizzarle

### 3. Documentazione
- Documentare le funzionalità specifiche del modulo
- Mantenere aggiornata la documentazione
- Includere esempi di utilizzo

## Esempio Completo

```php
<?php

namespace Modules\YourModule\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;
use YourModule\Filament\Resources\YourResource;
use YourModule\Http\Middleware\YourMiddleware;
use YourModule\Events\YourEvent;
use YourModule\Listeners\YourListener;
use Filament\Facades\Filament;

class YourModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'YourModule';

    public function boot(): void
    {
        parent::boot();
        $this->registerResources();
        $this->registerMiddleware();
        $this->registerEvents();
    }

    protected function registerResources(): void
    {
        if (class_exists(Filament::class)) {
            Filament::registerResources([
                YourResource::class,
            ]);
        }
    }

    protected function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware('your-middleware', YourMiddleware::class);
    }

    protected function registerEvents(): void
    {
        $this->app['events']->listen(YourEvent::class, YourListener::class);
    }
}
```

## Note Importanti
1. Mantenere il provider il più snello possibile
2. Utilizzare le funzionalità fornite da XotBaseServiceProvider
3. Aggiungere solo funzionalità specifiche del modulo
4. Documentare eventuali personalizzazioni
5. Testare tutte le funzionalità aggiunte 