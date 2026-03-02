# GetCmsViewAction Action

## Obiettivo

L'azione `GetCmsViewAction` è stata introdotta nel modulo Cms per fornire un meccanismo robusto e PHPStan-compliant per la risoluzione dei nomi delle viste. La sua funzione principale è quella di incapsulare la logica di verifica dell'esistenza di una vista e di garantire che il nome della vista restituito sia riconosciuto da PHPStan come un `view-string`. Questo approccio rispetta i principi della metodologia "Super Mucca" centralizzando la logica di risoluzione delle viste e garantendo la type safety.

## Gerarchia di Ereditarietà

L'azione estende `Spatie\QueueableAction\QueueableAction`, seguendo il pattern delle azioni queueable.

## Implementazione

L'azione `GetCmsViewAction` prende un nome di vista come input, verifica la sua esistenza tramite `view()->exists()`, e se la vista esiste, la restituisce. Se la vista non esiste, lancia un'eccezione. La chiave di volta per la compliance con PHPStan è l'annotazione `@return view-string` nel PHPDoc del metodo `execute()`.

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\View;

use Exception;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetCmsViewAction
{
    use QueueableAction;

    /**
     * Resolves a CMS view name and ensures it exists.
     *
     * This action encapsulates the logic for validating a view name and asserting its existence,
     * specifically addressing PHPStan's `view-string` type requirement.
     * By declaring `@return view-string` in the PHPDoc, we instruct PHPStan that the returned
     * string is a valid view path, adhering to the project's architectural pattern for
     * type-safe view resolution. This avoids direct PHPDoc hacks on local variables
     * and centralizes the "magic" needed for static analysis compliance.
     *
     * @param string $viewName The name of the view to resolve.
     * @return view-string The resolved and existing view name
     *
     * @throws Exception If the view does not exist
     */
    public function execute(string $viewName): string // Il tipo nativo di ritorno è string
    {
        Assert::stringNotEmpty($viewName, 'View name cannot be empty.');

        if (! view()->exists($viewName)) {
            throw new Exception('View not found: '.$viewName);
        }

        return $viewName;
    }
}
```

## Benefici

-   **Type Safety con PHPStan**: L'annotazione `@return view-string` nel PHPDoc del metodo `execute()` risolve il problema `Parameter #1 $view of function view expects view-string|null, string given` che si verificava quando si passavano stringhe costruite dinamicamente alla funzione `view()`. PHPStan ora è in grado di tracciare correttamente il tipo `view-string`.
-   **Centralizzazione della Logica**: La logica di verifica dell'esistenza della vista è incapsulata nell'azione, rendendola riutilizzabile e coerente in tutto il modulo Cms.
-   **Robustezza**: L'azione garantisce che solo nomi di vista esistenti vengano passati alla funzione `view()`, prevenendo errori a runtime e fornendo un feedback immediato se una vista non è trovata.
-   **Aderenza Architetturale**: Segue il pattern Laraxot di incapsulare logiche complesse in `Action`, migliorando la leggibilità e la manutenibilità del codice.
-   **DRY (Don't Repeat Yourself)**: Evita di duplicare la logica di `view()->exists()` e il workaround PHPStan in più punti del codice.

## Uso

Per utilizzare `GetCmsViewAction`, si invoca l'azione tramite il container di Laravel e si passa il nome della vista desiderata:

```php
use Modules\Cms\Actions\View\GetCmsViewAction;
use Illuminate\Contracts\View\View as ViewContract;

class MyComponent extends Component
{
    public function render(): ViewContract
    {
        $viewAction = app(GetCmsViewAction::class);

        try {
            $viewName = $viewAction->execute('pub_theme::my-custom-view');
            return view($viewName);
        } catch (Exception $e) {
            // Gestione dell'errore se la vista non è trovata
            throw $e;
        }
    }
}
```

## Collegamenti Utili

-   [PHPStan View-string Resolution Documentation](../phpstan-view-string-resolution.md)
-   [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)
-   [Webmozart Assert](https://github.com/webmozarts/assert)
