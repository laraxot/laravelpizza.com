# Wizard Widget Rules — XotBaseWizardWidget

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Rules / Filament  
**Audience**: All developers working with wizard widgets

---

## La Regola Fondamentale

**OGNI widget il cui `getFormSchema()` contiene un `Wizard` DEVE estendere `XotBaseWizardWidget`, NON `XotBaseWidget`.**

Questa regola non e negoziabile. E la base del contratto architetturale Laraxot.

**Nota (Filament pannello)**: su `CreateRecord` il trait `HasWizard` usa `getSteps()` / `hasSkippableSteps()` ([doc](https://filamentphp.com/docs/5.x/resources/creating-records#using-a-wizard)). Qui nel widget: `getSteps()` / `hasSkippableWizardSteps()` su `XotBaseWizardWidget` — stesso componente `Wizard`, contesto frontoffice.

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

// ✅ CORRETTO (pattern attuale Filament)
// Policy e persist query step gestite da XotBaseWizardWidget::getWizardComponent() + HasWizard
```

**Perche**: `XotBaseWizardWidget` orchestra `HasWizard`, view tema e (dove abilitato) `persistStepInQueryString`; non introdurre resolver custom paralleli senza ADR.

---

### 5. NON aggiungi layer PHP che riscrive tutto lo stato dopo `getState()`
```php
// ❌ DA EVITARE (frattura col contratto Filament)
public function submit(): void
{
    $flat = $this->someNormalize($this->form->getState()); // duplica / diverge dallo schema
    Model::create($flat);
}

// ✅ PATTERN FIXCITY (ticket wizard)
public function submit(): void
{
    /** @var array<string, mixed> $data */
    $data = $this->form->getState();
    $userId = auth()->id();
    if ($userId !== null) {
        $data['owner_id'] ??= $userId;
    }
    Ticket::create($data);
}
```

**Perche**: la forma delle chiavi deve restare **ownership dello schema/dehydrate**. Se servono chiavi flat sul modello, si corregge **`TicketForm`/component** o cast/mutator sul modello — non una “normalizzazione universale” sulla base widget.

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

### 9. DEFINIRAI `getSteps()` come metodo pubblico
```php
// ✅ CORRETTO
public function getSteps(): array
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
- Separazione delle responsabilita: base class chiama `getSteps()`, dominio definisce gli step
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
- [ ] Submit/persist usa `$this->form->getState()` senza riscrivere tutto il payload in helper generici (solo merge dominio documentati, es. `owner_id`)
- [ ] `getSteps()` e pubblico
- [ ] Step builders sono privati
- [ ] Submit button segue pattern corretto (HTML nativo o tema)
- [ ] Traduzioni seguono pattern `{namespace}::{widget_name}.*`

---

*Ultimo aggiornamento: 2026-04-14*
