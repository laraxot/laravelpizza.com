# Architettura Modulo Xot - Widgets & Wizards

## XotBaseWizardWidget

`XotBaseWizardWidget` è la classe base per tutti i widget multi-step (wizard) del progetto. Estende `XotBaseWidget` e utilizza il trait nativo di Filament `HasWizard` per la gestione dello stato e del rendering del form.

### Integrazione con i Temi

A differenza dei wizard standard di Filament (che sono pensati principalmente per l'area admin), `XotBaseWizardWidget` è progettato per funzionare in contesti diversi (admin e frontoffice):

1.  **Risoluzione della View**: La view del componente Wizard viene impostata dinamicamente tramite `getWizardComponent()`. Se non siamo in admin, viene utilizzata `pub_theme::components.wizard` per garantire la parità visiva con il design di sistema (es. Design Comuni).
2.  **Metodi di Supporto**: Per supportare le view personalizzate, il widget implementa metodi aggiuntivi non presenti nel trait standard di Filament:
    *   `getWizardDisplayStep()`: Restituisce l'indice (1-based) dello step corrente per il rendering dello stepper.
    *   `getWizardSteps()`: Metodo astratto che deve restituire l'array di step del wizard.

### Best Practices

*   **Non definire `$view`**: Non definire la proprietà `protected string $view` nelle sottoclassi. La view del widget è gestita internamente per risolvere correttamente il componente wizard.
*   **Utilizzo di parent::**: Quando si esegue l'override di metodi del trait `HasWizard` (come `getWizardComponent`), utilizzare l'aliasing del trait per poter chiamare la logica originale se necessario.
*   **Traduzioni**: Utilizzare sempre i namespace delle traduzioni (`xot::...`) per le label delle azioni (Next, Previous, Submit).

## Convenzioni di Naming

*   Classi: `[NomeAzione]WizardWidget` (es. `CreateTicketWizardWidget`)
*   Metodo di salvataggio: `save()` (configurato tramite `getSubmitFormLivewireMethodName()`)
