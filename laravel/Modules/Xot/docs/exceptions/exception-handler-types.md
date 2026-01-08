# ExceptionHandler Types - Tipizzazione e Best Practices

## Overview

Documentazione sui tipi di ritorno e la tipizzazione corretta per `ExceptionHandler` nel modulo Xot, con particolare attenzione alla conformità PHPStan livello 9.

## Metodo handles()

### Problema Identificato

PHPStan segnala che il metodo `handles()` non ha un tipo di ritorno specificato:

```
Method Modules\Xot\Exceptions\ExceptionHandler::handles() has no return type specified.
```

### Soluzione

Il metodo `handles()` è un metodo di configurazione che registra callback per la gestione delle eccezioni. Non restituisce valori, quindi il tipo di ritorno corretto è `void`:

```php
public static function handles(Exceptions $exceptions): void
{
    $exceptions->render(function (HttpException $e, Request $request) {
        $status_code = $e->getStatusCode();
        
        if ($request->wantsJson()) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $status_code);
        }
        
        $view = 'pub_theme::errors.' . $status_code;
        if (!view()->exists($view)) {
            throw new \Exception('view not found: [' . $view . '] view path:' . app(GetViewPathAction::class)->execute($view));    
        }
        
        $view_params = ['exception' => $e];
        return response()->view($view, $view_params, $status_code);
    });
}
```

## Struttura Completa della Classe

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Modules\Xot\Actions\View\GetViewPathAction;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionHandler 
{
    /**
     * Configura la gestione delle eccezioni.
     *
     * @param Exceptions $exceptions Configuratore eccezioni Laravel
     * @return void
     */
    public static function handles(Exceptions $exceptions): void
    {
        $exceptions->render(function (HttpException $e, Request $request) {
            $status_code = $e->getStatusCode();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $status_code);
            }
            
            $view = 'pub_theme::errors.' . $status_code;
            if (!view()->exists($view)) {
                throw new \Exception('view not found: [' . $view . '] view path:' . app(GetViewPathAction::class)->execute($view));    
            }
            
            $view_params = ['exception' => $e];
            return response()->view($view, $view_params, $status_code);
        });
    }
}
```

## Principi di Tipizzazione

### 1. Tipo di Ritorno void

- Il metodo `handles()` configura il sistema, non restituisce valori
- Uso esplicito di `void` per chiarezza e conformità PHPStan

### 2. Parametri Tipizzati

- `Exceptions $exceptions`: Configuratore delle eccezioni Laravel
- Tutti i parametri dei callback hanno tipi espliciti

### 3. Callback Tipizzati

```php
$exceptions->render(function (HttpException $e, Request $request) {
    // Callback con parametri tipizzati
    // Restituisce Response|JsonResponse
});
```

## Best Practices

### 1. Strict Types

```php
declare(strict_types=1);
```

### 2. PHPDoc Completo

```php
/**
 * Configura la gestione delle eccezioni.
 *
 * @param Exceptions $exceptions Configuratore eccezioni Laravel
 * @return void
 */
```

### 3. Gestione Eccezioni Interne

```php
if (!view()->exists($view)) {
    throw new \Exception('view not found: [' . $view . '] view path:' . app(GetViewPathAction::class)->execute($view));    
}
```

## Testing

Dopo le modifiche, verificare:

1. **PHPStan**: `./vendor/bin/phpstan analyze Modules/Xot/app/Exceptions --level=9`
2. **Funzionalità**: Test delle pagine di errore
3. **JSON Response**: Test delle API con errori

## Pattern di Utilizzo

### Registrazione nel Bootstrap

```php
// In bootstrap/app.php o equivalente
use Modules\Xot\Exceptions\ExceptionHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withExceptions(function (Exceptions $exceptions) {
        ExceptionHandler::handles($exceptions);
    })
    ->create();
```

### Estensione per Altri Moduli

Altri moduli possono estendere questo pattern:

```php
class ModuleExceptionHandler
{
    public static function handles(Exceptions $exceptions): void
    {
        // Configurazioni specifiche del modulo
        $exceptions->render(function (ModuleSpecificException $e, Request $request) {
            // Gestione specifica
        });
    }
}
```

## Monitoraggio

- Verificare che le pagine di errore vengano renderizzate correttamente
- Monitorare i log per eccezioni non gestite
- Testare sia le risposte HTML che JSON

## Collegamenti

- [Handler Decorator](handler-decorator.md)
- [PHPStan Collection Types](../phpstan-collection-types.md)
- [Exception Handling Guidelines](../development-rules.md)

*Ultimo aggiornamento: Gennaio 2025* 