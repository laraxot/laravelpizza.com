# XotBaseWizardWidget — Architettura, bellezza e bug del primo step sempre visibile

> **⚠️ Aggiornamento 2026-05-22** — contesto HasWizard + `getWizardComponent()` aggiornato in [`filament-wizard-refactoring.md`](../filament-wizard-refactoring.md). **`normalizeWizardFormState()` non esiste più sulla base**: il submit dominio usa **`$this->form->getState()`**; eventuale trait **`DelegatesFilamentWizardSchemaMethods`** solo dove serve Blade.
>
> **Domanda d'origine**: *"come mai il 1° step rimane sempre visibile?"*

## TL;DR

Il widget eredita `getStartStep()` dal trait `HasWizard` di Filament che ritorna
**hard-coded `1`**. Il docblock del widget promette che `getStartStep()` legge
`?step=` dalla request, ma **non c'e' alcun override**: a runtime la promessa
non viene mai mantenuta. La property `$wizardStartStep`, valorizzata nelle
sottoclassi (es. `CreateTicketWizardWidget::mount()`), e' una **dynamic
property** non dichiarata: in PHP 8.2+ e' deprecata e in ogni caso non e' letta
da nessun metodo del widget. Il wizard quindi parte sempre dal primo step.

## Catena di eredita'

```
Filament\Widgets\Widget                    (Livewire-based)
        |
        v
XotBaseWidget                              (xot::filament.widgets.base)
   - form(Schema): Schema  ←--- chiamato da parent::form() della trait
   - getFormSchema(): array (default [])
        |
        v
XotBaseWizardWidget         (abstract)
   - use HasWizard { getWizardComponent as getParentWizardComponent; }
   - abstract getSteps(): array
   - getCancelFormAction(): Action
   - getSaveFormAction(): Action
   - getSubmitFormAction(): Action  (=> getSaveFormAction)
   - getSubmitFormLivewireMethodName(): 'save'
        |
        v
CreateTicketWizardWidget    (concrete, Fixcity)
   - getSteps(): array      [privacy, data, summary]
   - mount(): $this->wizardStartStep = 1;   ← dynamic property
```

Il trait `Filament\Resources\Pages\Concerns\HasWizard` mette in tavola:

```php
public function getStartStep(): int { return 1; }

public function form(Schema $schema): Schema
{
    return parent::form($schema)        // ← XotBaseWidget::form()
        ->columns(null)
        ->components([ $this->getWizardComponent() ]);
}

public function getWizardComponent(): Component
{
    return Wizard::make($this->getSteps())
        ->startOnStep($this->getStartStep())
        ->cancelAction($this->getCancelFormAction())
        ->submitAction($this->getSubmitFormAction())
        ->alpineSubmitHandler("\$wire.{$this->getSubmitFormLivewireMethodName()}()")
        ->skippable($this->hasSkippableSteps())
        ->contained(false);
}
```

> Quando una trait fornisce un metodo gia' presente nella **parent class**, il
> metodo della trait vince. Quando il metodo e' anche nella **using class**,
> vince la using class. Qui `XotBaseWidget::form()` viene oscurato da
> `HasWizard::form()` perche' la trait e' aggregata in `XotBaseWizardWidget`
> e quindi sta "piu' vicino" alla classe finale.

## Perche' il primo step e' sempre visibile

Il rendering Alpine del wizard ha questa struttura (vendor):

```html
<!-- vendor/filament/schemas/resources/views/components/wizard.blade.php -->
<div class="fi-sc-wizard" x-data="wizardSchemaComponent({ startStep: 1, ... })">
    <input type="hidden" x-ref="stepsData" value='["privacy","data","summary"]'>
    @foreach ($steps as $step) {{ $step }} @endforeach
</div>

<!-- vendor/filament/schemas/resources/views/components/wizard/step.blade.php -->
<div class="fi-sc-wizard-step"
     x-bind:class="{ 'fi-active': step === @js($key) }"
     x-cloak>
    {{ $getChildSchema() }}
</div>
```

E il JS Alpine (`wizard.js`):

```js
init() {
    this.step = this.getSteps().at(startStep - 1)   // → "privacy"
    // ...
}
```

La visibilita' viene applicata dal CSS del tema
(`Themes/Sixteen/resources/css/components/filament-wizard-parity.css`):

```css
.fi-sc-wizard .fi-sc-wizard-step          { display: none !important; }
.fi-sc-wizard .fi-sc-wizard-step.fi-active { display: block !important; }
```

Catena causale:

1. `Wizard::startOnStep($this->getStartStep())` → `startOnStep(1)`.
2. La view passa ad Alpine `startStep: 1`.
3. Alpine: `this.step = steps[0]` → la chiave del **primo** step (es. `"privacy"`).
4. Solo lo step con `$key === "privacy"` riceve `.fi-active`.
5. Il CSS nasconde tutti gli altri, mostra il primo. 

Risultato: il wizard **parte sempre dal primo step**.  Il docblock del widget
(`getStartStep() legge ?step= dalla request`) descrive una **funzionalita' non
implementata** nella classe corrente — manca l'override di `getStartStep()`
e/o un metodo `resolveInitialStepFromQuery()`.

### Perche' `wizardStartStep` non risolve

`CreateTicketWizardWidget::mount()` fa:

```php
$this->wizardStartStep = 1;
```

Ma:

- `XotBaseWizardWidget` **non dichiara** `public int $wizardStartStep`.
- L'assegnazione crea una **dynamic property** (deprecata da PHP 8.2 — emette
  warning a meno che la classe non abbia `#[AllowDynamicProperties]`).
- Nessun metodo della catena la legge: `getWizardComponent()` invoca
  `$this->getStartStep()` che e' ancorato al return `1` del trait.

Per attivare la promessa del docblock servirebbe **uno** di questi pattern:

```php
// (A) Override esplicito in XotBaseWizardWidget
public ?int $wizardStartStep = null;

public function getStartStep(): int
{
    return $this->wizardStartStep
        ?? $this->resolveInitialStepFromQuery()
        ?? 1;
}

// (B) Override di getWizardComponent con Closure dinamica
public function getWizardComponent(): Component
{
    return Wizard::make($this->getSteps())
        ->startOnStep(fn (): int => $this->wizardStartStep ?? 1)
        ->cancelAction($this->getCancelFormAction())
        ->submitAction($this->getSubmitFormAction())
        // ... attenzione: cancelAction accetta string|Htmlable|null,
        // Action e' Htmlable solo via ViewComponent (vedi sotto)
        ->persistStepInQueryString('step');
}
```

## La bellezza del codice (cose ben fatte)

### 1. Trait aliasing per accedere al parent

```php
use HasWizard {
    getWizardComponent as getParentWizardComponent;
}
```

Pattern PHP avanzato: aliasare il metodo della trait significa potersi
costruire dentro la classe finale un override che chiami il **vecchio**
metodo trait per riusarne la logica:

```php
public function getWizardComponent(): Component
{
    // logica custom...
    $wizard = $this->getParentWizardComponent();
    // ulteriore decorazione...
    return $wizard;
}
```

Anche se l'override non e' presente nel file attuale, l'alias e'
**predisposto**: la classe e' progettata per esporre un hook futuro.

### 2. Separazione semantica save / submit

```php
protected function getSaveFormAction(): Action      // → button "save", mod+s
protected function getSubmitFormAction(): Action    // → alias di save
protected function getSubmitFormLivewireMethodName(): string { return 'save'; }
```

- `save` = azione di **persistenza** (con keybinding `mod+s`, condizionale
  `submit()` vs `action()` in base alla presenza del form wrapper).
- `submit` = identita' verso il save (default), ma **estendibile** dalle
  sottoclassi che vogliono cambiare il method name livewire o aggiungere
  pre-submit hooks.
- Il method name livewire (`save`) e' isolato in un metodo dedicato → si puo'
  ridefinire una sottoclasse senza toccare il rendering Filament.

### 3. Cancel action con SPA-aware fallback

```php
protected function getCancelFormAction(): Action
{
    $url = $this->previousUrl ?? $this->getResourceUrl();

    return Action::make('cancel')
        ->label(__('filament-panels::resources/pages/edit-record.form.actions.cancel.label'))
        ->alpineClickHandler(
            FilamentView::hasSpaMode($url)
                ? 'document.referrer ? window.history.back() : Livewire.navigate(' . Js::from($url) . ')'
                : 'document.referrer ? window.history.back() : (window.location.href = ' . Js::from($url) . ')',
        )
        ->color('gray');
}
```

Punti forti:

- **Branch SPA vs full reload** in base a `FilamentView::hasSpaMode($url)` →
  rispetta la configurazione panel-per-panel.
- **`document.referrer` come prima scelta**: il click cancel fa preferenza a
  un `history.back()` (UX naturale), e ricade su `Livewire.navigate(...)` solo
  se la storia e' vuota (deep link).
- **`Js::from(...)`**: encoding sicuro server→client che evita XSS quando l'URL
  contiene caratteri speciali.
- Il colore `gray` allinea il cancel al pattern Bootstrap Italia.

### 4. `getResourceUrl` con `record` auto-iniettato

```php
public function getResourceUrl(?string $name = null, array $parameters = [], ...): string
{
    if (filled($name) && ($name !== 'index') && method_exists($this, 'getRecord')) {
        $parameters['record'] ??= $this->getRecord();
    }
    return static::getResource()::getUrl(...);
}
```

- Inietta automaticamente `record` quando l'URL non e' l'index e il widget
  espone `getRecord()` (duck typing tramite `method_exists`, senza
  vincolare il contratto della parent class).
- `??=` (null coalescing assignment) e' usato in modo idiomatico: rispetta i
  parametri gia' passati dall'esterno.

### 5. Property `$columnSpan = 'full'`

Eredita da `XotBaseWidget` ma viene ridichiarato con tipo
`int|string|array` per esplicitare l'intento: i widget wizard **sempre**
occupano l'intera colonna dello schema. Si tratta di una micro-dichiarazione
con valore semantico — convey intent senza commenti.

### 6. Comment-as-architecture

Il docblock e' particolarmente curato:

> *"Usa `use HasWizard` (alias `getParentWizardComponent`) ma NON chiama il
> trait direttamente a runtime: `HasWizard::getWizardComponent()` chiama
> `->cancelAction(Action)` e `->submitAction(Action)` ma
> `Wizard::cancelAction()` accetta solo `string|Htmlable|null` — `Action`
> non e' `Htmlable` nel contesto widget."*

Documenta in modo preciso **una limitazione concreta del vendor** che ha
guidato il design (la motivazione del bypass via override mancante).

## Conseguenze pratiche per chi modifica il widget

- Per fare partire il wizard da uno step diverso al mount serve **override di
  `getStartStep()`** (o di `getWizardComponent()`), **non** una assegnazione a
  `$this->wizardStartStep`.
- Per il routing `?step=` serve un `resolveInitialStepFromQuery()` che parsi
  la querystring lato Livewire (in `mount()` o `boot()`), e va combinato con
  `Wizard::persistStepInQueryString('step')` per il loop browser↔server.
- Le sottoclassi che gia' assegnano `$this->wizardStartStep = N` non producono
  alcun effetto: andrebbe rimosso o convertito a proprieta' pubblica + override
  di `getStartStep()`.

## Refactor minimale suggerito (proposta)

```php
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    use EvaluatesClosures;
    use HasWizard { getWizardComponent as getParentWizardComponent; }

    public ?int $wizardStartStep = null;

    abstract public function getSteps(): array;

    public function getStartStep(): int
    {
        return $this->wizardStartStep
            ?? $this->resolveInitialStepFromQuery()
            ?? 1;
    }

    protected function resolveInitialStepFromQuery(): ?int
    {
        $raw = request()->query('step');
        if (! is_string($raw) && ! is_int($raw)) {
            return null;
        }

        if (is_numeric($raw)) {
            $candidate = max(1, (int) $raw);
            $count = count($this->getSteps());
            return $candidate <= $count ? $candidate : null;
        }

        $keys = collect($this->getSteps())
            ->map(static fn (Step $step): ?string => $step->getKey())
            ->values();
        $position = $keys->search($raw);
        return $position === false ? null : ($position + 1);
    }
}
```

Vantaggi:

1. La promessa del docblock diventa reale.
2. `$wizardStartStep` viene dichiarata come **public property Livewire**
   (reattiva, persistente cross-request).
3. Le sottoclassi tornano a poter scrivere `$this->wizardStartStep = N`
   senza incorrere in dynamic property warnings.
4. Il routing `?step=` supporta sia indici numerici che chiavi Filament.

## Cross-reference

- `Modules/Xot/docs/architettura.md` — vista d'insieme su Xot widgets.
- `Modules/Fixcity/docs/wiki/concepts/wizard-step-index-and-map-integration-rule.md`
  — convenzioni sul tracking dello step lato Livewire.
- `Modules/Fixcity/docs/wiki/concepts/wizard-zen-philosophy.md` — pattern
  consigliati per i wizard del dominio Fixcity.
- `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` —
  consumer del widget base.

---

*Creato: 2026-05-14 — Claude Opus 4.7, analisi `XotBaseWizardWidget`.*
