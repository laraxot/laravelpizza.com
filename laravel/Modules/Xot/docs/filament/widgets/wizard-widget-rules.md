# Wizard Widget Rules — XotBaseWizardWidget

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-05-04  
**Category**: Architecture / Rules / Filament  
**Audience**: All developers working with wizard widgets

---

## La Regola Fondamentale

**OGNI widget il cui `getFormSchema()` contiene un `Wizard` DEVE estendere `XotBaseWizardWidget`, NON `XotBaseWidget`.**

Questa regola non e negoziabile. E la base del contratto architetturale Laraxot.

**Nota (Filament pannello)**: su `CreateRecord` il trait `HasWizard` usa `getSteps()` / `hasSkippableSteps()` ([doc](https://filamentphp.com/docs/5.x/resources/creating-records#using-a-wizard)). Qui nel widget: `getWizardSteps()` / `hasSkippableWizardSteps()` su `XotBaseWizardWidget` — stesso componente `Wizard`, contesto frontoffice.

### Filament `HasWizard` in vendor (non duplicare a caso)

| Trait | Namespace | Contesto |
|-------|-----------|----------|
| `HasWizard` | `Filament\Actions\Concerns` | Wizard dentro **Action** (modale); API `steps()` |
| `HasWizard` | `Filament\Resources\Pages\Concerns` | **Pagina** Resource: `form(Schema)` con `Wizard::make($this->getSteps())`, `hasSkippableSteps()` |
| (wrapper) | `Filament\Resources\Pages\CreateRecord\Concerns\HasWizard` | Re-export del trait **Pages** |

Il widget Livewire `XotBaseWizardWidget` **non** estende `CreateRecord` ne `Page`: **non** si puo attaccare il trait **Pages** senza rifattorare tutto il flusso `form(Schema)` della page. Si riusa lo stesso componente schema `Wizard` / `Step` e si allinea il comportamento (es. skippable steps). Story: `_bmad-output/implementation-artifacts/8-114-xotbasewizard-filament-haswizard-parity-segnalazione-crea-cta.md`.

---

## I 10 Comandamenti del Wizard Widget

### 1. NON userai `->label()` esplicito
```php
// ❌ SBAGLIATO
TextInput::make('address')
    ->label('Indirizzo')  // Ridondante!

// ✅ CORRETTO
TextInput::make('address')
    ->required()  // LangServiceProvider applica label automaticamente
```

**Perche**: LangServiceProvider configura automaticamente label, placeholder, helperText, tooltip per TUTTI i componenti Filament via `AutoLabelAction`.

**Pattern chiave**: `{namespace}::{widget_snake_case}.{type}.{name}.{property}`  
**Esempio**: `fixcity::create_ticket_wizard.fields.address.label`

---

### 2. NON userai `->tooltip()` esplicito
```php
// ❌ SBAGLIATO
Action::make('next')
    ->tooltip('Vai al passo successivo')  // Ridondante!

// ✅ CORRETTO
// Nessun tooltip necessario - LangServiceProvider lo applica
```

**Perche**: Stesso motivo delle label. Il tooltip e auto-configurato.

---

### 3. NON scriverai `Log::error()` nel widget dominio
```php
// ❌ SBAGLIATO
catch (\Throwable $e) {
    Log::error('Submit failed', ['exception' => $e->getMessage()]);  // Non e compito del dominio!
    Notification::make()->danger()->send();
}

// ✅ CORRETTO
catch (\Throwable $e) {
    // Mostra notifica user-friendly generica
    $message = (string) __('mymodule::widget.notifications.submit_failed.body');
    $this->addError('data.submit', $message);
    
    Notification::make()
        ->title((string) __('mymodule::widget.notifications.submit_failed.title'))
        ->body($message)
        ->danger()
        ->send();
    
    // Log dettagliato: compito di logging.php, non del dominio
}
```

**Perche**: 
- Il widget dominio deve mostrare solo notifiche user-friendly
- I log dettagliati sono gestiti dal framework (logging.php)
- Separazione delle responsabilita: dominio ≠ infrastruttura

---

### 4. NON reinventerai la logica di `?step=`
```php
// ❌ SBAGLIATO
protected function resolveInitialStepFromQuery(): int
{
    // Tua implementazione custom...  // Duplicazione!
}

// ✅ CORRETTO
$this->wizardStartStep = $this->resolveInitialStepFromQuery();  // Ereditato da XotBaseWizardWidget
```

**Perche**: XotBaseWizardWidget gestisce:
- Lettura sicura di `?step=` con validazione range 1..N
- Policy sicurezza (solo local/debug/config-enabled)
- Normalizzazione stato annidato

---

### 5. NON dimenticherai `normalizeWizardFormState()` nel submit
```php
// ❌ SBAGLIATO
public function submit(): void
{
    $data = $this->form->getState();
    // Usa $data direttamente...  // Stato annidato!
}

// ✅ CORRETTO
public function submit(): void
{
    $state = $this->form->getState();
    $data = $this->normalizeWizardFormState($state);  // Appiattisce stato
    // Ora $data['address'] funziona correttamente
}
```

**Perche**: Se il Wizard e wrappato da una chiave (es. `data['wizard']['address']`), devi appiattirlo per accedere a `data['address']`.

---

### 6. NON overriding `configureWizardNextAction()` per label/tooltip
```php
// ❌ SBAGLIATO
protected function configureWizardNextAction(Action $action): Action
{
    return $action
        ->label(__('mymodule::widget.actions.next.label'))      // Ridondante!
        ->tooltip(__('mymodule::widget.actions.next.tooltip')); // Ridondante!
}

// ✅ CORRETTO (solo per icon o comportamento custom)
protected function configureWizardNextAction(Action $action): Action
{
    return $action
        ->icon('heroicon-o-arrow-right');  // OK: icon non e auto-configurata
}
```

**Perche**: Label e tooltip sono auto-configurati da LangServiceProvider. Override solo per:
- Icon custom
- Comportamenti speciali (`requiresConfirmation()`, ecc.)

---

### 7. NON overriding `configureWizardPreviousAction()` per label/tooltip
Stesso motivo del comandamento #6.

---

### 8. USERAI il submit button pattern corretto
```php
// ✅ CORRETTO (se vuoi bottone HTML nativo con classi Design Comuni)
protected function getWizardSubmitAction(): Htmlable
{
    $label = (string) __('mymodule::widget.actions.submit.label');
    
    return new HtmlString(
        "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
    );
}

// Nel Blade template:
<form wire:submit="submit">
    {{ $this->form }}
</form>
```

**Perche**: 
- `Action::submit('submit')` e rotto (crea form chiamato 'submit')
- Bottone HTML nativo con `type="submit"` delega correttamente a `<form wire:submit="...">`

---

### 9. DEFINIRAI `getWizardSteps()` come metodo pubblico
```php
// ✅ CORRETTO
public function getWizardSteps(): array
{
    return [
        $this->makeStepPrivacy(),
        $this->makeStepData(),
        $this->makeStepSummary(),
    ];
}

private function makeStepPrivacy(): Step { /* ... */ }
private function makeStepData(): Step { /* ... */ }
private function makeStepSummary(): Step { /* ... */ }
```

**Perche**: 
- Separazione delle responsabilita: base class chiama `getWizardSteps()`, dominio definisce gli step
- Ogni step builder e privato (incapsulamento dominio-specifico)

---

### 10. ESTENDERAI solo XotBaseWizardWidget per wizard multi-step
```php
// ✅ CORRETTO
class CreateTicketWizardWidget extends XotBaseWizardWidget { }

// ❌ SBAGLIATO
class CreateTicketWizardWidget extends XotBaseWidget { }  // WRONG!
```

**Perche**: XotBaseWidget non gestisce:
- Navigazione multi-step
- Persistenza `?step=`
- Normalizzazione stato annidato
- Policy sicurezza step query

---

## Filosofia / Religione / Zen

### Il Perche Profondo

```
XotBaseWidget (contratto generico: form lineare + statePath('data'))
       ↓
XotBaseWizardWidget (specializzazione: protocollo wizard multi-step)
       ↓
CreateTicketWizardWidget (dominio concreto: creazione ticket)
```

**La visione**:
- **Base class** = protocollo (navigazione, sicurezza, stato)
- **Domain widget** = contenuto (campi, validazione, business logic)

**Lo Zen**:
> "Il dominio descrive gli step, la base governa il protocollo."

**La religione**:
> "DRY + KISS + Separazione delle Responsabilita"

**La politica**:
> "Niente duplicazioni, niente reinvenzioni, niente log nel dominio"

---

## Riferimenti Incrociati

- [XotBaseWizardWidget Implementation](../../../app/Filament/Widgets/XotBaseWizardWidget.php)
- [XotBaseWizardWidget Philosophy](./xot-base-wizard-widget-philosophy.md)
- [LangServiceProvider Auto-Label](../../../../Lang/app/Providers/LangServiceProvider.php)
- [AutoLabelAction](../../../../Lang/app/Actions/Filament/AutoLabelAction.php)
- [CreateTicketWizardWidget Example](../../../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php)
- [Filament Wizard Rules (Fixcity)](../../../../Fixcity/docs/filament-wizard-rule.md)

---

## Checklist Pre-Commit

Prima di committare un wizard widget, verifica:

- [ ] Estende `XotBaseWizardWidget` (NON `XotBaseWidget`)
- [ ] NO `->label()` espliciti su campi/azioni
- [ ] NO `->tooltip()` espliciti su azioni
- [ ] NO `Log::error()` nel catch block
- [ ] Usa `$this->resolveInitialStepFromQuery()` nel mount
- [ ] Usa `$this->normalizeWizardFormState()` nel submit (se stato annidato)
- [ ] `getWizardSteps()` e pubblico
- [ ] Step builders sono privati
- [ ] Submit button segue pattern corretto (HTML nativo o tema)
- [ ] Traduzioni seguono pattern `{namespace}::{widget_name}.*`

---

*Ultimo aggiornamento: 2026-04-14*
