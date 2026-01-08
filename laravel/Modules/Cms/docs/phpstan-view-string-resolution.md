# Risoluzione Problemi PHPStan per `view-string`

## Contesto

Durante il refactoring di componenti Filament e Blade (`DownloadAttachmentPlaceHolder`, `Section.php`), è emerso un errore persistente da PHPStan (Larastan) relativo al tipo `view-string`:

```
Parameter #1 $view of function view expects view-string|null, string given.
PHPDoc tag @var with type view-string is not subtype of native type non-falsy-string.
```

Questo errore si verifica perché PHPStan, nella sua analisi statica, non riesce a determinare che una stringa passata alla funzione `view()` sia effettivamente un percorso di vista valido (`view-string`), specialmente quando il percorso è costruito dinamicamente o non direttamente hardcoded.

## Problemi Identificati con Tentativi Iniziali

1.  **Cast `(string)` diretto**: Inefficace, PHPStan non riconosce `(string)` come `view-string`.
2.  **PHPDoc `/** @var view-string $variable */`**: Inizialmente suggerito dalla documentazione del progetto, ma ha causato un errore `varTag.nativeType` quando applicato direttamente a variabili locali in alcuni contesti, indicando un conflitto tra il tipo PHPDoc e il tipo nativo percepito da PHPStan.
3.  **PHPDoc `/** @var view-string|string $variable */`**: Tentativo di mitigare l'errore precedente, ma ha portato a errori diversi e non ha risolto il problema di fondo.
4.  **Helper `getCmsView()` con PHPDoc `@return view-string`**: Questo è stato un tentativo di "ingannare" PHPStan con un PHPDoc sulla funzione helper, ma è stato giustamente identificato come un "hack" ("cagata pazzesca") che non risolve il problema alla radice e non rispetta i principi di type safety robusta del progetto.

## Lezione Appresa: "PHPDoc Hacks" non sono Soluzioni Reali

L'approccio "Super Mucca" e i principi Laraxot richiedono soluzioni che siano `DRY + KISS + SOLID + Robust`. Utilizzare PHPDoc per forzare un tipo che PHPStan non riesce a inferire naturalmente, o per mascherare un problema di type safety, non è una soluzione sostenibile e introduce debito tecnico.

## Soluzione Architetturale: Utilizzo di `Action` per la Risoluzione delle View

La chiave per risolvere questo problema risiede nell'adesione ai pattern architetturali del progetto, in particolare l'uso di `Action` per logiche specifiche. L'esistenza di `Modules\Xot\Actions\View\GetViewByClassAction.php` (che sebbene non direttamente applicabile per la logica, dimostra il pattern) e l'enfasi sulle "Cast Actions Centralizzate" suggeriscono che la risoluzione di un `view-string` dovrebbe avvenire tramite un'azione dedicata.

Un'azione che si occupa di "risolvere una view e garantirne l'esistenza" è il punto corretto per applicare il PHPDoc `@return view-string`, perché è lì che viene garantita la correttezza del percorso della vista.

### Nuova Implementazione (Corretta) del Pattern `GetCmsViewAction`

Per il modulo Cms, è stata creata l'azione `Modules\Cms\Actions\View\GetCmsViewAction`. Questa azione:

1.  Accetta un nome di vista come `string`.
2.  Utilizza `Webmozart\Assert\Assert` per validare l'input.
3.  Verifica l'esistenza della vista tramite `view()->exists()`.
4.  **Criticamente**, dichiara `@return view-string` nel suo PHPDoc. È a questo livello che PHPStan dovrebbe fidarsi che la stringa restituita è, di fatto, una `view-string`.

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
     * @param string $viewName The name of the view to resolve.
     * @return view-string The resolved and existing view name.
     *
     * @throws Exception If the view does not exist.
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

### Utilizzo in `Cms\View\Components\Section.php` (Esempio)

Il componente `Section` viene modificato per invocare questa azione:

```php
// ...
use Modules\Cms\Actions\View\GetCmsViewAction;

class Section extends Component
{
    // ...
    public function render(): ViewContract
    {
        $viewAction = app(GetCmsViewAction::class);
        $baseViewName = 'pub_theme::components.sections.'.$this->slug;
        if ($this->tpl) {
            $baseViewName .= '.'.$this->tpl;
        }

        try {
            $view = $viewAction->execute($baseViewName);
            return view($view);
        } catch (Exception $e) {
            $fallbackView = $viewAction->execute('cms::components.section');
            return view($fallbackView);
        }
    }
}
```

## Benefici di questo Approccio

-   **Type Safety Reale**: La validazione dell'esistenza della vista avviene a runtime nell'azione.
-   **PHPStan Compliant**: PHPStan è soddisfatto perché l'azione dichiara esplicitamente di restituire un `view-string`.
-   **Aderenza Architetturale**: Segue il pattern di centralizzazione delle logiche complesse in `Action`.
-   **DRY/KISS**: La logica di verifica `view()->exists()` e il cast PHPDoc `view-string` sono incapsulati e riutilizzabili.
-   **Robustezza**: L'azione lancia un'eccezione se la vista non è trovata, garantendo un comportamento prevedibile.

## Passi Futuri e Miglioramenti

-   Assicurarsi che tutte le view create dinamicamente o risolte tramite logiche complesse passino attraverso azioni o helper appositamente tipizzati.
-   Documentare accuratamente l'uso di queste azioni nei vari moduli.
-   Considerare l'implementazione di un `XotBaseViewAction` se la logica di risoluzione delle view diventa comune a più moduli.

## Conclusione

La risoluzione degli errori `view-string` non deve avvenire tramite scorciatoie o PHPDoc mal posizionati. L'approccio corretto, in linea con la metodologia "Super Mucca" e i principi Laraxot, è incapsulare la logica di risoluzione delle view in un'azione dedicata che si assume la responsabilità di restituire un `view-string` validato, permettendo così a PHPStan di eseguire correttamente la sua analisi statica.
