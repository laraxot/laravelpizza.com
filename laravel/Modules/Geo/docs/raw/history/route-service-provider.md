# RouteServiceProvider nei Moduli PTVX

Questo documento descrive le linee guida per l'implementazione corretta del RouteServiceProvider nei moduli PTVX.

## Struttura Base

Ogni modulo deve avere un proprio `RouteServiceProvider` che estende `XotBaseRouteServiceProvider`. Questo service provider è responsabile della registrazione delle route del modulo.

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider {
    // Implementazione
}
```

## Proprietà Obbligatorie

Il RouteServiceProvider deve definire le seguenti proprietà:

1. **public string $name**: Nome del modulo in formato PascalCase/CamelCase con prima lettera maiuscola
   ```php
   public string $name = 'NomeModulo';
   ```

2. **protected string $moduleNamespace**: Namespace per i controller del modulo
   ```php
   protected string $moduleNamespace = 'Modules\NomeModulo\Http\Controllers';
   ```

3. **protected string $module_dir**: Directory del modulo (default: `__DIR__`)
   ```php
   protected string $module_dir = __DIR__;
   ```

4. **protected string $module_ns**: Namespace del modulo (default: `__NAMESPACE__`)
   ```php
   protected string $module_ns = __NAMESPACE__;
   ```

## Errori Comuni

### Nome del Modulo Mancante o Errato

Se viene mostrato l'errore `name is empty on [Modules\NomeModulo\Providers\RouteServiceProvider]`, significa che:

1. La proprietà `$name` non è stata definita nel RouteServiceProvider
2. È stata utilizzata una proprietà con un nome differente
3. Il nome non è in formato PascalCase con la prima lettera maiuscola

**Correzione**:
```php
// ERRATO
// Manca completamente la proprietà $name

// ERRATO
public string $module_name = 'NomeModulo';

// ERRATO
public string $name = 'nomemodulo';

// CORRETTO
public string $name = 'NomeModulo';
```

## Relazione con il ServiceProvider Principale

È importante che il nome del modulo sia coerente tra il `RouteServiceProvider` e il `NomeModuloServiceProvider` principale. Entrambi devono utilizzare lo stesso valore per la proprietà `$name`.

## Esempio Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider {
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Blog\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'Blog';
}
```
