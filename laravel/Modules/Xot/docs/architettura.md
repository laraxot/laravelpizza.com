# Architettura Modulo Xot - Widgets & Wizards

## XotBaseWizardWidget

<<<<<<< HEAD
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
=======
`XotBaseWizardWidget` estende `XotBaseWidget` e usa **`Filament\Resources\Pages\Concerns\HasWizard`** per costruire il componente `Wizard` sullo schema; la classe la completa con `getWizardComponent()` (vista tema, persistenza `step` in URL dove prevista, `columnSpanFull`). Il submit salvataggio leggere **`$this->form->getState()`** nel widget dominio, senza helper di normalizzazione sulla base; Blade delegate opzionali **`DelegatesFilamentWizardSchemaMethods`** dove presenti.

### Integrazione con i Temi

Il wizard non-admin usa **`pub_theme::components.wizard`** (`getWizardComponent()`). La view Livewire del widget viene risolta come per ogni `XotBaseWidget` (`GetViewByClassAction`). Il submit ultimo step segue **`HasWizard` + Action “save”** (metodo Livewire **`save()`** suggerito dall’azione); i widget dominio espongono spesso **`submit()`** con pipeline dedicata prima di salvare il model.

*   **`getSteps()`**: come `HasWizard` sul panel — deve restituire gli `Step` (tipicamente da uno schema tipo `TicketForm::getSteps()` con chiavi stringa quando servono nei query param).

### Best Practices

*   **Non definire `$view`**: la view del widget si risolve via `resolveView()`; documentare eventualmente `@view …` nel docblock.
*   **Hook**: vedere [`filament/widgets/xot-base-wizard-widget.md`](filament/widgets/xot-base-wizard-widget.md).
*   **Traduzioni**: namespace via LangServiceProvider; evitare `->label()` hardcoded nei campi quando coperto dalla convenzione modulo.
>>>>>>> 40b96bcd6 (.)

## Convenzioni di Naming

*   Classi: `[NomeAzione]WizardWidget` (es. `CreateTicketWizardWidget`)
<<<<<<< HEAD
*   Metodo di salvataggio: `save()` (configurato tramite `getSubmitFormLivewireMethodName()`)
=======
*   **Livewire save**: dalla base viene esposto `getSubmitFormLivewireMethodName() → save` azione Wizard; nei widget dominio si può aggiungere **`submit()`** per pipeline prima di **`save()`**/persistenza.
>>>>>>> 40b96bcd6 (.)
