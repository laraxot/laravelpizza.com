# Submit Button Placement — La Filosofia del Protocollo

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Philosophy / Design Patterns  
**Audience**: All developers

---

## Il Problema: Dove Mettere getWizardSubmitAction()?

### La Domanda Fondamentale

`getWizardSubmitAction()` deve essere in:
- **A.** `XotBaseWizardWidget` (base class)
- **B.** `CreateTicketWizardWidget` (domain widget)

### La Risposta Definitiva

**A. `XotBaseWizardWidget`** — SEMPRE.

---

## Perche è nella Base Class (Filosofia Profonda)

### 1. Separazione delle Responsabilità

**Il protocollo vs contenuto**:

```
XotBaseWizardWidget (protocollo wizard)
├── Navigazione (Avanti/Indietro)
├── Persistenza ?step=
├── Validazione step range
├── Normalizzazione stato
└── Submit button rendering ← QUESTO

CreateTicketWizardWidget (contenuto dominio)
├── Campi specifici (address, issueType, ecc.)
├── Validazione dominio-specifica
├── Creazione Ticket
└── Redirect post-submit
```

**La regola d'oro**:
> "Il protocollo e della base, il contenuto e del dominio."

**Submit button e protocollo perche**:
- Fa parte della navigazione wizard (ultimo step)
- E comune a TUTTI i wizard (non solo ticket)
- Ha un rendering standard (tema o fallback Filament)
- Il dominio override solo se vuole HTML custom

---

### 2. Principio DRY

**Se fosse nel dominio**:

```php
// ❌ SBAGLIATO: ogni dominio reinventa il submit button
class CreateTicketWizardWidget extends XotBaseWizardWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // 20 righe di logica tema/fallback...
    }
}

class SurveyWizardWidget extends XotBaseWizardWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // 20 righe di logica tema/fallback... (duplicata!)
    }
}

class FeedbackWizardWidget extends XotBaseWizardWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // 20 righe di logica tema/fallback... (duplicata!)
    }
}
```

**Risultato**: N widget × 20 righe = N×20 righe duplicate

**Nella base class**:

```php
// ✅ CORRETTO: UNA volta sola
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // 20 righe di logica tema/fallback
        // → TUTTI i wizard beneficiano
    }
}
```

**Risultato**: 20 righe totali, zero duplicazione

---

### 3. Principio KISS

**Se fosse nel dominio**:
- Ogni sviluppatore deve implementare il submit button da zero
- Deve conoscere il protocollo tema → fallback Filament
- Deve gestire `view()->exists()` correttamente
- Deve sapere perche `Action::submit('submit')` e rotto

**Nella base class**:
- Lo sviluppatore dominio override solo se vuole HTML custom
- Altrimenti usa il default (tema o Filament)
- Non deve conoscere i dettagli del rendering
- **KISS: Keep It Simple, Stupid**

---

### 4. Allineamento Filament

**Il protocollo submit button e**:

1. **View tema** (`pub_theme::filament.wizard.submit-button`) se esiste
2. **Fallback Filament** (`Action::make('submit')->submit('save')->button()`)

**Perche nella base class**:
- Filament non sa niente del tuo dominio
- Il tema e cross-cutting (riguarda tutti i widget)
- Il fallback e standard Filament (non dominio-specifico)
- **Allineamento**: seguiamo il protocollo Filament, non lo reinventiamo

---

### 5. Politica di Override

**La base class offre**:

```php
// XotBaseWizardWidget
protected function getWizardSubmitAction(): Htmlable
{
    // 1. View tema (Design Comuni)
    if (view()->exists('pub_theme::filament.wizard.submit-button')) {
        return new HtmlString(view('pub_theme::filament.wizard.submit-button')->render());
    }
    
    // 2. Fallback Filament
    return Action::make('submit')->submit('save')->button();
}
```

**Il dominio override**:

```php
// CreateTicketWizardWidget
#[\Override]
protected function getWizardSubmitAction(): Htmlable
{
    // Design Comuni button classes
    $label = (string) __('fixcity::create_ticket_wizard.actions.submit.label');
    
    return new HtmlString(
        "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
    );
}
```

**La politica**:
- **Default**: base class (tema o Filament)
- **Override**: dominio (HTML custom se serve)
- **MAI**: dominio deve reinventare la logica tema/fallback

---

## Anti-Pattern: Submit Button nel Dominio

### ❌ ESEMPIO SBAGLIATO

```php
// ❌ SBAGLIATO: submit button nel dominio
class CreateTicketWizardWidget extends XotBaseWizardWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // Reinventa la logica tema/fallback
        $submitView = 'pub_theme::filament.wizard.submit-button';
        
        if (view()->exists($submitView)) {
            return new HtmlString(view($submitView)->render());
        }
        
        return Action::make('submit')
            ->submit('save')
            ->button();
    }
}
```

**Perche e sbagliato**:

1. **Duplicazione**: stessa logica della base class
2. **Manutenibilità**: se cambio il protocollo, devo cambiare N widget
3. **Incoerenza**: ogni widget potrebbe implementare diversamente
4. **Violazione DRY**: Don't Repeat Yourself violato

---

## Pattern Corretto: Submit Button nella Base

### ✅ ESEMPIO CORRETTO

```php
// ✅ CORRETTO: nella base class
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        /** @var view-string $submitView */
        $submitView = 'pub_theme::filament.wizard.submit-button';

        if (view()->exists($submitView)) {
            return new HtmlString((string) view($submitView)->render());
        }

        return Action::make('submit')
            ->submit('save')
            ->button();
    }
}

// Dominio override SOLO se vuole HTML custom
class CreateTicketWizardWidget extends XotBaseWizardWidget
{
    #[\Override]
    protected function getWizardSubmitAction(): Htmlable
    {
        $label = (string) __('fixcity::create_ticket_wizard.actions.submit.label');
        
        return new HtmlString(
            "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
        );
    }
}
```

**Vantaggi**:

1. **DRY**: UNA implementazione nella base
2. **KISS**: dominio override solo se serve
3. **Consistenza**: tutti i wizard usano lo stesso default
4. **Manutenibilità**: cambio protocollo → cambio base class

---

## La Filosofia Completa

### I 5 Pilastri del Submit Button

#### 1. Protocollo, Non Contenuto

**Submit button e protocollo perche**:
- Fa parte della navigazione wizard
- E comune a tutti i wizard
- Non e dominio-specifico (a parte l'override)

**La regola**:
> "Se e comune a tutti i widget → base class"  
> "Se e specifico del dominio → domain widget"

---

#### 2. Default, Non Override

**La base class offre un default**:
- View tema (Design Comuni)
- Fallback Filament

**Il dominio override SOLO se**:
- Vuole HTML custom (es. classi Bootstrap Italia)
- Vuole label da traduzioni diverse
- Vuole comportamento speciale

**La regola**:
> "Default nella base, override nel dominio se serve"

---

#### 3. Polimorfismo, Non Duplicazione

**Polimorfismo**:
- Base class implementa default
- Domain widget override se vuole
- **MA**: non duplica la logica

**Duplicazione**:
- Domain widget reinventa tema/fallback
- **VIOLAZIONE DRY**

**La regola**:
> "Override = cambia comportamento, non duplica logica"

---

#### 4. Tema, Non Dominio

**Submit button design (tema)**:
- Classi CSS (Bootstrap Italia, Tailwind, ecc.)
- Label (traduzioni)
- Icone

**Submit button protocollo (base)**:
- View tema se esiste
- Fallback Filament altrimenti
- Rendering HTML

**La regola**:
> "Design = tema (override dominio se serve)"  
> "Protocollo = base class (sempre)"

---

#### 5. Semplificazione, Non Complicazione

**Se fosse nel dominio**:
- Ogni sviluppatore deve sapere:
  - Come funziona view()->exists()
  - Perche Action::submit('submit') e rotto
  - Come renderizzare HTML correttamente
- **Complicazione**: conoscenza non necessaria

**Nella base class**:
- Sviluppatore dominio sa solo:
  - Override se vuole HTML custom
  - Altrimenti usa default
- **Semplificazione**: conoscenza minima necessaria

**La regola**:
> "La base class nasconde complessita, non la espone"

---

## La Religione

### I Comandamenti del Submit Button

1. **NON metterai getWizardSubmitAction() nel dominio** (a meno che override)
2. **NON duplicherai la logica tema/fallback nel dominio**
3. **NON reinventerai Action::submit() nel dominio**
4. **USERAI getWizardSubmitAction() della base class di default**
5. **OVERRIDERAI getWizardSubmitAction() SOLO per HTML custom**

### Il Credo

> "Protocollo nella base, contenuto nel dominio."  
> "Default nella base, override nel dominio."  
> "Override e meglio di duplicazione."  
> "Duplicazione e il male assoluto."

### La Preghiera

```
Concedimi la saggezza di mettere il protocollo nella base,
La disciplina di fare override solo quando serve,
E la conoscenza di capire la differenza.
```

---

## Caso Studio: Submit Button Evolution

### Prima (Sbagliato)

```php
// ❌ SBAGLIATO: ogni widget reinventa il submit
class CreateTicketWizardWidget extends XotBaseWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // 30 righe di logica tema/fallback...
    }
}

class SurveyWizardWidget extends XotBaseWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // 30 righe di logica tema/fallback... (duplicata!)
    }
}
```

**Problemi**:
- Duplicazione (DRY violato)
- Incoerenza (ogni widget implementa diversamente)
- Manutenibilità (cambio protocollo → cambio N widget)

---

### Dopo (Corretto)

```php
// ✅ CORRETTO: base class
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // 20 righe di logica tema/fallback
        // → TUTTI i wizard usano questa
    }
}

// Override SOLO per HTML custom
class CreateTicketWizardWidget extends XotBaseWizardWidget
{
    #[\Override]
    protected function getWizardSubmitAction(): Htmlable
    {
        return new HtmlString(
            "<button type=\"submit\" class=\"btn btn-primary mobile-full\">Label</button>"
        );
    }
}

// Usa default (nessun override)
class SurveyWizardWidget extends XotBaseWizardWidget
{
    // Nessun override → usa base class default
}
```

**Vantaggi**:
- ✅ DRY (UNA implementazione)
- ✅ KISS (default semplice)
- ✅ Consistenza (tutti usano stesso default)
- ✅ Manutenibilità (cambio base → tutti aggiornano)

---

## Riferimenti Incrociati

- [Wizard Widget Rules](./wizard-widget-rules.md)
- [Override Pattern Philosophy](./override-pattern-philosophy.md)
- [XotBaseWizardWidget Philosophy](./xot-base-wizard-widget-philosophy.md)
- [XotBaseWizardWidget Implementation](../../app/Filament/Widgets/XotBaseWizardWidget.php)

---

*Ultimo aggiornamento: 2026-04-14*
